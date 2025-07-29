<?php

declare(strict_types=1);

namespace PaymentReport\Services;

use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\Collection;
use PaymentReport\Models\Attributes\Concerns\CriteriaAttributeInterface;
use PaymentReport\Models\DTO\CriteriaData;
use PaymentReport\Models\DTO\IntervalData;
use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\PaymentReportDetails;
use App\Queue\Services\Jobs\Contracts\JobDispatcherServiceInterface;
use App\Repositories\Locations\District\DistrictRepository;
use App\Repositories\Locations\Region\RegionRepository;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PaymentReport\Http\Requests\Params\CreatePresetParams;
use PaymentReport\Http\Requests\Params\CreateReportParams;
use PaymentReport\Http\Requests\Params\UpdatePresetParams;
use PaymentReport\Http\Resources\PaymentPresetInformationResource;
use PaymentReport\Http\Resources\PaymentReportInformationResource;
use PaymentReport\Jobs\DataGenerationJob;
use PaymentReport\Repositories\Contracts\ReportDetailsRepositoryInterface;
use PaymentReport\Repositories\Criteria\List\PresetsByFrequencyQueryCriteria;
use PaymentReport\Repositories\Criteria\List\PresetTypeQueryCriteria;
use PaymentReport\Repositories\ReportRepository;
use PaymentReport\Services\Contracts\ReportPaymentFileEnsurerServiceInterface;
use Throwable;

class ReportService
{
    public function __construct(
        private readonly ReportDetailsRepositoryInterface $detailsRepository,
        private readonly ReportRepository $repository,
        private readonly JobDispatcherServiceInterface $dispatcherService,
        private readonly ReportPaymentFileEnsurerServiceInterface $reportPaymentFileEnsurerService,
        private readonly RegionRepository $regionRepository,
        private readonly DistrictRepository $districtRepository,
    ) {
    }

    public function createPresetEntity(CreatePresetParams $params): PaymentPresetInformationResource
    {
        $result = DB::transaction(function () use ($params) {
            $attributes = $params->getPresetAttributes();
            $attributes[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA] = array_merge(
                $attributes[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA],
                $this->getReverseAttributes($params)
            );

            /** @var PaymentReportDetails $preset */
            $preset = $this->createDetails(GenerationTypeName::preset->value, $attributes);

            return $preset;
        });

        return PaymentPresetInformationResource::make($result);
    }

    public function updatePresetEntity(
        PaymentReportDetails $preset,
        UpdatePresetParams $params
    ): PaymentPresetInformationResource {
        $result = DB::transaction(function () use ($preset, $params) {
            $attributes = $params->getPresetAttributes();
            $this->updateDetails($preset, $attributes);

            return $preset->refresh();
        });

        return PaymentPresetInformationResource::make($result);
    }

    public function createDetails(string $typeName, array $attributes): Model
    {
        return $this->detailsRepository
            ->create(array_merge(['type' => $typeName], $attributes));
    }

    public function updateDetails(PaymentReportDetails $preset, array $attributes): Model
    {
        return $this->detailsRepository->update($preset->getKey(), $attributes);
    }

    public function createManual(CreateReportParams $params): PaymentReportInformationResource
    {
        $result = DB::transaction(function () use ($params) {
            $attributes = $params->getReportAttributes();
            $attributes[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA] = array_merge(
                $attributes[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA],
                $this->getReverseAttributes($params)
            );

            /** @var PaymentReport $report */
            $report = $this->repository->createReport(
                $params->getDates(),
                $params->getCreatedById()
            );

            /** @var PaymentReportDetails $preset */
            $preset = $this->createDetails(GenerationTypeName::manual->value, $attributes);

            $report->setDetails($preset->getKey());
            $report->save();

            // todo: send notification that report is ready
            $this->dispatcherService->dispatch(new DataGenerationJob($preset));

            return $report;
        });

        return PaymentReportInformationResource::make($result);
    }

    public function createReportFromPreset(PaymentReportDetails $preset, IntervalData $datePeriod): PaymentReport
    {
        return DB::transaction(function () use ($datePeriod, $preset) {
            /** @var PaymentReport $report */
            $report = $this->repository->createReport(
                $datePeriod->toArray()
            );

            $report->setDetails($preset->getKey());
            $report->save();

            $this->reportPaymentFileEnsurerService->ensureFile($preset);

            return $report->refresh();
        });
    }

    public function getAutomaticPresets(Frequency $frequency): Collection
    {
        return $this->detailsRepository->makeQuery(
            [
                new PresetTypeQueryCriteria(GenerationTypeName::preset),
                new PresetsByFrequencyQueryCriteria($frequency)
            ],
            [],
            [
                PaymentReportDetails::qualifyAttribute('*')
            ]
        )->get();
    }

    public function deletePresetEntity(array $params): bool
    {
        foreach ($params as $presetId) {
            $this->detailsRepository->delete($presetId);
        }

        return true;
    }

    public function deleteReportEntity(array $ids): bool
    {
        $reports = $this->repository->getReportByIds($ids);

        foreach ($reports as $report) {
            /** @type $report PaymentReport */
            DB::transaction(function () use ($report) {
                try {
                    $report->details()->delete();
                    $report->delete();
                } catch (Throwable $exception) {
                    throw new CustomException($exception->getMessage(), $exception->getCode());
                }
            });
        }

        return true;
    }

    private function getReverseAttributes(CreatePresetParams|CreateReportParams $params): array
    {
        $reverseAttributes = [];
        if ($params->isReverseField('region_id')) {
            $ids = $params->getCriteriaData()[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA][CriteriaData::REGION];
            $reverseAttributes[CriteriaData::REGION] = $this->regionRepository->findAllFieldValuesExcept('id', $ids);
        }

        if ($params->isReverseField('district_id')) {
            $ids = $params->getCriteriaData()[CriteriaAttributeInterface::ATTRIBUTE_CRITERIA][CriteriaData::DISTRICT];
            $reverseAttributes[CriteriaData::DISTRICT]
                = $this->districtRepository->findAllFieldValuesExcept('id', $ids);
        }

        return $reverseAttributes;
    }
}
