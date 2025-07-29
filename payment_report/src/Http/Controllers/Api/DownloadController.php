<?php

declare(strict_types=1);

namespace PaymentReport\Http\Controllers\Api;

use App\Http\Responses\ZipStreamResponse;
use Payment\Http\Requests\PaymentReport\BulkDownloadRequest;
use PaymentReport\Models\PaymentReport;
use OpenApi\Attributes as OAA;
use Payment\Http\Controllers\Api\ApiController;
use PaymentReport\Services\FileRequestService;
use PaymentReport\Services\PaymentReportProcessRequestService;
use Processes\Http\Resources\ProcessShortResource;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends ApiController
{
    public function __construct(private readonly FileRequestService $fileRequestService)
    {
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/download',
            summary: 'Download reports. Bulk and single',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'file[]',
            description: 'Report File ids',
            in: 'query',
            schema: new OAA\Schema(
                type: 'array',
                items: new OAA\Items(type: 'string', format: 'uuid')
            ),
        ),
        OAA\Response(
            ref: ('api-docs.json#/components/schemas/ProcessShortResource'),
            response: Response::HTTP_OK,
            description: 'Successful operation',
        ),
        OAA\Response(
            ref: 'api-docs.json#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function bulkDownload(
        BulkDownloadRequest $request,
        PaymentReportProcessRequestService $processRequestService
    ): ProcessShortResource {
        return $processRequestService->createProcess($request);
    }

    #[
        OAA\Get(
            path: '/api/v1/payment-reports/{paymentReport}/download',
            summary: 'Download report. Single. May be unused',
            security: [['bearer_token' => []]],
            tags: ['Reports Payments'],
        ),
        OAA\Parameter(
            name: 'paymentReport',
            description: 'Id of the Report',
            in: 'path',
            schema: new OAA\Schema(type: 'string', format: 'uuid')
        ),
        OAA\Response(
            response: Response::HTTP_OK,
            description: 'Successful operation',
        ),
        OAA\Response(
            ref: 'api-docs.json#/components/schemas/Unauthenticated',
            response: Response::HTTP_UNAUTHORIZED,
            description: 'Unauthenticated',
        )
    ]
    public function download(PaymentReport $report): ZipStreamResponse
    {
        return $this->fileRequestService->download($report);
    }
}
