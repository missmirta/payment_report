<?php

declare(strict_types=1);

namespace PaymentReport\Services;

use App\Http\Responses\ZipStreamResponse;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Services\Contracts\ReportPaymentFileEnsurerServiceInterface;

final class FileRequestService
{
    public function __construct(private readonly ReportPaymentFileEnsurerServiceInterface $fileEnsurerService)
    {
    }

    public function download(PaymentReport $report): ZipStreamResponse
    {
        $this->fileEnsurerService->ensureFile($report->getDetails());

        return ZipStreamResponse::create('Report ID:(' . $report->getKey() . ')')
            ->addFiles($report->fresh()->getFile());
    }
}
