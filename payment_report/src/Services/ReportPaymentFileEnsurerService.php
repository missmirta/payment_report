<?php

declare(strict_types=1);

namespace PaymentReport\Services;

use App\Log\Extended\Services\Contracts\LoggingServiceInterface;
use FilesystemExtended\Models\Contracts\FileInterface;
use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use PaymentReport\Models\Relation\Contracts\HasReportRelationInterface;
use PaymentReport\Services\Contracts\ReportPaymentFileEnsurerServiceInterface;
use PdfServices\Exceptions\Plugins\PdfGenerator\PdfGenerationException;
use PdfServices\Plugins\PdfGenerator\Contracts\PdfPluginManagerInterface;
use function is_null;

class ReportPaymentFileEnsurerService implements ReportPaymentFileEnsurerServiceInterface
{
    public function __construct(
        private readonly PdfPluginManagerInterface $pluginManager,
        private readonly LoggingServiceInterface $loggingService,
    ) {
    }

    public function ensureFile(PaymentReportDetailsInterface $paymentReportDetails): void
    {
        $report = $paymentReportDetails->getUnGeneratedReport();

        if (is_null($report) || $report->getFile() instanceof FileInterface) {
            return;
        }

        try {
            $file = $this->pluginManager->getInstance($paymentReportDetails)->generatePDF($paymentReportDetails);
            $report->setFile($file->getKey())->saveQuietly();
        } catch (PdfGenerationException $exception) {
            $this->loggingService->error($exception->getMessage(), $exception->getContext());
        }

        $paymentReportDetails->load(HasReportRelationInterface::RELATION_REPORT);
    }
}
