<?php

declare(strict_types=1);

namespace PaymentReport\Http\Controllers\Api;

use PaymentReport\Models\PaymentReportDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAA;
use PaymentReport\Http\Requests\CreatePaymentReportPresetRequest;
use PaymentReport\Http\Requests\CreatePaymentReportRequest;
use PaymentReport\Http\Requests\UpdatePaymentReportPresetRequest;
use PaymentReport\Http\Resources\PaymentPresetInformationResource;
use PaymentReport\Services\ListService;
use PaymentReport\Services\ReportService;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends ApiController
{
    #[
        OAA\Post(
            path: '/api/v1/payment-reports/preset',
            summary: 'Create the report preset for Automatic Report',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\RequestBody(
            content: new OAA\JsonContent(ref: '#/components/schemas/CreatePaymentReportPresetRequest'),
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
                        ref: '#/components/schemas/PaymentPresetInformationResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function createPreset(
        CreatePaymentReportPresetRequest $request,
        ReportService $service
    ): JsonResponse {
        return $this->responseCreated($service->createPresetEntity($request->getParams()));
    }

    #[
        OAA\Put(
            path: '/api/v1/payment-reports/{paymentReportPreset}/preset',
            summary: 'Update the reports preset for Automatic Report',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'paymentReportPreset',
            description: 'Id of the Preset',
            in: 'path',
            schema: new OAA\Schema(type: 'string', format: 'uuid')
        ),
        OAA\RequestBody(
            content: new OAA\JsonContent(ref: '#/components/schemas/UpdatePaymentReportPresetRequest'),
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
                        ref: '#/components/schemas/PaymentPresetInformationResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function updatePreset(
        UpdatePaymentReportPresetRequest $request,
        PaymentReportDetails $preset,
        ReportService $service
    ): JsonResponse {
        return $this->responseUpdated($service->updatePresetEntity($preset, $request->getParams()));
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/{paymentReportPreset}/preset',
            summary: 'Get the reports preset for Automatic Report',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'paymentReportPreset',
            description: 'Id of the Preset',
            in: 'path',
            schema: new OAA\Schema(type: 'string', format: 'uuid')
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
                        ref: '#/components/schemas/PaymentPresetInformationResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function getPreset(
        PaymentReportDetails $preset,
    ): JsonResponse {
        return $this->responseOk(
            PaymentPresetInformationResource::make($preset),
            trans('responses.general.fetch_success')
        );
    }

    #[
        OAA\Post(
            path: '/api/v1/payment-reports/manual',
            summary: 'Create the Manual report',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\RequestBody(
            content: new OAA\JsonContent(ref: '#/components/schemas/CreatePaymentReportRequest'),
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
                        ref: '#/components/schemas/PaymentReportInformationResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function createManual(
        CreatePaymentReportRequest $request,
        ReportService $service
    ): JsonResponse {
        return $this->responseCreated($service->createManual($request->getParams()));
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/get-basis',
            summary: 'Get Report Basis according to structure level of user',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
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
                        ref: 'api-docs.json#/components/schemas/StructureLevelResource'
                    )
                ],
            ),
        ),
        OAA\Response(
            ref: '#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
        ),
    ]
    public function getReportBasisByStructureLevel(Request $request, ListService $service): JsonResponse
    {
        return $this->responseOk($service->getReportBasis($request->user()));
    }
}
