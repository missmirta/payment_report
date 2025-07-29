<?php

declare(strict_types=1);

namespace PaymentReport\Services;

use App\Http\Resources\StructureLevel\StructureLevelResource;
use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use PaymentReport\Models\Contracts\PaymentReportInterface;
use PaymentReport\Models\Counts\Type;
use PaymentReport\Models\Relation\Contracts\HasDetailsRelationInterface;
use App\Models\User;
use App\Services\Resources\ResourceTransformer;
use PaymentReport\Http\Resources\ReportCountsResource;
use PaymentReport\Models\Enum\GenerationTypeName;
use App\Repositories\StructureLevel\StructureLevelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use PaymentReport\Http\Requests\Counts\ReportCountsRequest;
use PaymentReport\Http\Requests\ReportAutomaticListRequest;
use PaymentReport\Http\Requests\ReportManualListRequest;
use PaymentReport\Http\Requests\ReportPresetListRequest;
use PaymentReport\Http\Resources\PaymentPresetListingResource;
use PaymentReport\Http\Resources\ReportPaymentAutomaticListingResource;
use PaymentReport\Http\Resources\ReportPaymentManualListingResource;
use PaymentReport\Repositories\Contracts\ReportDetailsRepositoryInterface;
use PaymentReport\Repositories\Contracts\ReportRepositoryInterface;
use PaymentReport\Repositories\Criteria\List\PresetListQueryCriteria;
use PaymentReport\Repositories\Criteria\List\ReportCreatedByQueryCriteria;
use PaymentReport\Repositories\Criteria\List\ReportDetailsSortCriteria;
use PaymentReport\Repositories\Criteria\List\ReportListGenerationTypeQueryCriteria;
use PaymentReport\Repositories\Criteria\List\ReportListQueryCriteria;
use PaymentReport\Repositories\Criteria\List\ReportSearchQueryCriteria;
use PaymentReport\Repositories\Criteria\List\ReportSortCriteria;

class ListService
{
    public function __construct(
        private readonly StructureLevelRepositoryInterface $repositoryBasis,
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly ReportDetailsRepositoryInterface $details
    ) {
    }

    public function getReportBasis(User $user): Collection
    {
        $result = $this->repositoryBasis->getList($user);

        ResourceTransformer::transformCollectionItems($result, new StructureLevelResource([]));

        return $result;
    }

    public function getAutomaticPaginatedList(ReportAutomaticListRequest $request): LengthAwarePaginator
    {
        $paginatedList = $this->reportRepository
            ->getPaginated(
                $request,
                [
                    new ReportListGenerationTypeQueryCriteria(GenerationTypeName::preset),
                    new ReportListQueryCriteria($request->getParams()),
                    new ReportSearchQueryCriteria($request->search()),
                    ReportSortCriteria::fromRequest($request)
                ],
                [HasDetailsRelationInterface::RELATION_DETAILS],
                [PaymentReportInterface::TABLE . '.*']
            );

        ResourceTransformer::transformCollectionItems($paginatedList, new ReportPaymentAutomaticListingResource([]));

        return $paginatedList;
    }

    public function getManualPaginatedList(ReportManualListRequest $request): LengthAwarePaginator
    {
        $paginatedList = $this->reportRepository
            ->getPaginated(
                $request,
                [
                    new ReportListGenerationTypeQueryCriteria(GenerationTypeName::manual),
                    new ReportListQueryCriteria($request->getParams()),
                    new ReportCreatedByQueryCriteria($request->getParams()),
                    new ReportSearchQueryCriteria($request->search()),
                    ReportSortCriteria::fromRequest($request)
                ],
                [HasDetailsRelationInterface::RELATION_DETAILS],
                [PaymentReportInterface::TABLE . '.*']
            );

        ResourceTransformer::transformCollectionItems($paginatedList, new ReportPaymentManualListingResource([]));

        return $paginatedList;
    }

    public function getPresetPaginatedList(ReportPresetListRequest $request): LengthAwarePaginator
    {
        $paginatedList = $this->details
            ->getPaginated(
                $request,
                [
                    new PresetListQueryCriteria(GenerationTypeName::preset, $request->getParams()),
                    ReportDetailsSortCriteria::fromRequest($request),
                ],
                [],
                [
                    PaymentReportDetailsInterface::TABLE . '.*'
                ]
            );

        ResourceTransformer::transformCollectionItems($paginatedList, new PaymentPresetListingResource([]));

        return $paginatedList;
    }

    public function getCountsList(ReportCountsRequest $request): ReportCountsResource
    {
        $filteredTypes = $request->getTypes();

        $counts = collect($filteredTypes)
            ->map(
                fn (string $key) => Type::tryFrom($key)
            )->reject(
                fn (Type|null $type) => empty($type)
            )->map(fn (Type $type) => [
                'type' => $type->value,
                'count' => $type->modelCount(),
            ]);

        return ReportCountsResource::make($counts);
    }
}
