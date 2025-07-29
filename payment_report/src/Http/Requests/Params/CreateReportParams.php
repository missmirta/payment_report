<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests\Params;

use PaymentReport\Models\Attributes\Concerns\CriteriaAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\DateFromAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\DateToAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PaymentReport\Models\DTO\CriteriaData;
use PaymentReport\Models\Enum\ReportType;
use App\Repositories\Common\Params\ReverseFieldsParamsTrait;
use PaymentReport\Models\Attributes\Concerns\BasisAttributeInterface;
use Carbon\Carbon;
use Survey\Models\Relations\Contracts\HasCreatedByRelationInterface;

class CreateReportParams
{
    use ReverseFieldsParamsTrait;

    protected function __construct(
        private readonly int $reportBasis,
        private readonly Carbon $dateFrom,
        private readonly Carbon $dateTo,
        private readonly ReportType $reportType,
        private readonly int $createdById,
        private readonly CriteriaData $criteriaData,
    ) {
    }

    public static function make(
        int $reportBasis,
        Carbon $dateFrom,
        Carbon $dateTo,
        ReportType $reportType,
        int $createdById,
        CriteriaData $criteriaData
    ): static {
        return new static(
            $reportBasis,
            $dateFrom,
            $dateTo,
            $reportType,
            $createdById,
            $criteriaData
        );
    }

    public function getReportAttributes(): array
    {
        return [
            BasisAttributeInterface::ATTRIBUTE_REPORT_BASIS => $this->getReportBasis(),
            ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE => $this->getReportType()->value,
            HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID => $this->getCreatedById()
        ] + $this->getCriteriaData();
    }

    public function getCriteriaData(): array
    {
        return [CriteriaAttributeInterface::ATTRIBUTE_CRITERIA => $this->criteriaData->toArray()];
    }

    public function getDates(): array
    {
        return [
            DateFromAttributeInterface::ATTRIBUTE_DATE_FROM => $this->getDateFrom(),
            DateToAttributeInterface::ATTRIBUTE_DATE_TO => $this->getDateTo(),
        ];
    }

    public function getReportBasis(): int
    {
        return $this->reportBasis;
    }

    public function getReportType(): ReportType
    {
        return $this->reportType;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function getDateFrom(): Carbon
    {
        return $this->dateFrom;
    }

    public function getDateTo(): Carbon
    {
        return $this->dateTo;
    }
}
