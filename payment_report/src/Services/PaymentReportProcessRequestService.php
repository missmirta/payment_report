<?php

declare(strict_types=1);

namespace PaymentReport\Services;

use App\Helpers\Str;
use Payment\Http\Requests\PaymentReport\BulkDownloadRequest;
use PaymentReport\Processes\DownloadReport\ProcessData;
use PaymentReport\Providers\ProcessServiceProvider;
use Processes\Http\Resources\ProcessShortResource;
use Processes\Repositories\Process\Params\CreateParams;
use Processes\Services\Process\Contracts\ProcessServiceInterface;

class PaymentReportProcessRequestService
{
    public function __construct(
        private readonly ProcessServiceInterface $processService,
    ) {
    }

    public function createProcess(BulkDownloadRequest $request): ProcessShortResource
    {
        return ProcessShortResource::make(
            $this->processService->create(CreateParams::make(
                type: ProcessServiceProvider::PROCESS_DOWNLOAD_PAYMENT_REPORTS,
                data: ProcessData::make(
                    fileIds: $request->getReportsFileIds(),
                    performerId: $request->getPerformerId(),
                    resultedFileName: Str::uuid()->toString() . '.zip'
                ),
            ))
        );
    }
}
