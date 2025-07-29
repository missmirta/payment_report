<?php

declare(strict_types=1);

namespace PaymentReport\Http\Controllers\Api;

use PaymentReport\Models\Counts\Type;
use PaymentReport\Models\Enum\ReportType;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAA;
use PaymentReport\Http\Requests\Counts\ReportCountsRequest;
use PaymentReport\Http\Requests\ReportAutomaticListRequest;
use PaymentReport\Http\Requests\ReportManualListRequest;
use PaymentReport\Http\Requests\ReportPresetListRequest;
use PaymentReport\Repositories\Criteria\List\ReportDetailsSortCriteria;
use PaymentReport\Repositories\Criteria\List\ReportSortCriteria;
use PaymentReport\Services\ListService;
use Symfony\Component\HttpFoundation\Response;

class ReportListController extends ApiController
{
    public function __construct(private readonly ListService $service)
    {
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/automatic',
            summary: 'Automatic report list',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'page',
            description: 'Current page',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'page_size',
            description: '',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'orderBy',
            description: 'Order by field',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ReportSortCriteria::ALLOWED_SORTING_FIELDS)
        ),
        OAA\Parameter(
            name: 'order',
            description: 'Order direction',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ['asc', 'desc'])
        ),
        OAA\Parameter(
            name: 'report_type[]',
            description: 'Report type',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(
                    type: 'string',
                    enum: [ReportType::customer, ReportType::vendor]
                )
            ),
        ),
        OAA\Parameter(
            name: 'report_basis[]',
            description: 'Report basis',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(
                    type: 'number'
                )
            ),
        ),
        OAA\Parameter(
            name: 'search',
            description: 'Search by Report name',
            in: 'query',
            schema: new OAA\Schema(type: 'string'),
        ),
        OAA\Response(
            response: Response::HTTP_OK,
            description: 'Successful operation',
            content: new OAA\JsonContent(ref: '#/components/schemas/ReportPaymentAutomaticListingResource'),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function automaticList(
        ReportAutomaticListRequest $request,
    ): JsonResponse {
        return $this->responsePaginate($this->service->getAutomaticPaginatedList($request));
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/manual',
            summary: 'Manual report list',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'page',
            description: 'Current page',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'page_size',
            description: '',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'orderBy',
            description: 'Order by field',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ReportSortCriteria::ALLOWED_SORTING_FIELDS)
        ),
        OAA\Parameter(
            name: 'order',
            description: 'Order direction',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ['asc', 'desc'])
        ),
        OAA\Parameter(
            name: 'report_type[]',
            description: 'Report type',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(
                    type: 'string',
                    enum: [ReportType::customer, ReportType::vendor]
                )
            ),
        ),
        OAA\Parameter(
            name: 'report_basis[]',
            description: 'Report basis',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(
                    type: 'number'
                )
            ),
        ),
        OAA\Parameter(
            name: 'search',
            description: 'Search by Report name',
            in: 'query',
            schema: new OAA\Schema(type: 'string'),
        ),
        OAA\Response(
            response: Response::HTTP_OK,
            description: 'Successful operation',
            content: new OAA\JsonContent(ref: '#/components/schemas/ReportPaymentManualListingResource'),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function manualList(
        ReportManualListRequest $request,
    ): JsonResponse {
        return $this->responsePaginate($this->service->getManualPaginatedList($request));
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/preset',
            summary: 'Preset list',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'page',
            description: 'Current page',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'page_size',
            description: '',
            in: 'query',
            schema: new OAA\Schema(type: 'number')
        ),
        OAA\Parameter(
            name: 'orderBy',
            description: 'Order by field',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ReportDetailsSortCriteria::ALLOWED_SORTING_FIELDS)
        ),
        OAA\Parameter(
            name: 'order',
            description: 'Order direction',
            in: 'query',
            schema: new OAA\Schema(type: 'string', enum: ['asc', 'desc'])
        ),
        OAA\Parameter(
            name: 'search',
            description: 'Search by preset name',
            in: 'query',
            schema: new OAA\Schema(type: 'string'),
        ),
        OAA\Response(
            response: Response::HTTP_OK,
            description: 'Successful operation',
            content: new OAA\JsonContent(ref: '#/components/schemas/PaymentPresetListingResource'),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function presetList(
        ReportPresetListRequest $request,
    ): JsonResponse {
        return $this->responsePaginate($this->service->getPresetPaginatedList($request));
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/counts',
            summary: 'Get list of reports counts',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'types[]',
            description: 'Report Types',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(
                    type: 'string',
                    enum: [
                        Type::Manual,
                        Type::Automatic,
                        Type::Preset
                    ]
                )
            ),
        ),
        OAA\Response(
            response: Response::HTTP_OK,
            description: 'Successful operation',
            content: new OAA\JsonContent(
                properties: [
                    new OAA\Property(
                        property: 'status',
                        type: 'string',
                    ),
                    new OAA\Property(
                        property: 'message',
                        type: 'string',
                    ),
                    new OAA\Property(
                        property: 'payload',
                        ref: 'api-docs.json#/components/schemas/ReportCountsResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function counts(ReportCountsRequest $request): JsonResponse
    {
        return $this->responseOk(
            $this->service->getCountsList($request),
            trans('responses.general.fetch_success')
        );
    }
}
