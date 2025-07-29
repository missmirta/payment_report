<?php

declare(strict_types=1);

namespace PaymentReport\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OAA;
use PaymentReport\Http\Requests\DeletePresetRequest;
use PaymentReport\Http\Requests\DeleteReportRequest;
use PaymentReport\Services\ReportService;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends ApiController
{
    #[
        OAA\Delete(
            path: '/api/v1/payment-reports/preset',
            summary: 'Delete the report preset. Bulk and single',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'preset[]',
            description: 'Preset ids',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(type: 'string', format: 'uuid')
            ),
        ),
        OAA\Response(
            response: Response::HTTP_ACCEPTED,
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
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function deletePreset(
        DeletePresetRequest $request,
        ReportService $service
    ): JsonResponse {
        return $this->responseDeleted(
            $service->deletePresetEntity($request->getPresetsIds()),
            trans('responses.general.delete_success')
        );
    }

    #[
        OAA\Delete(
            path: '/api/v1/payment-reports',
            summary: 'Delete the report. Bulk and single',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'report[]',
            description: 'Report ids',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(type: 'string', format: 'uuid')
            ),
        ),
        OAA\Response(
            response: Response::HTTP_ACCEPTED,
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
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function deleteReport(
        DeleteReportRequest $request,
        ReportService $service
    ): JsonResponse {
        return $this->responseDeleted(
            $service->deleteReportEntity($request->getReportIds()),
            trans('responses.general.delete_success')
        );
    }
}
