<?php

declare(strict_types=1);

namespace PaymentReport\PdfGenerator;

use FilesystemExtended\Plugins\FilePresets\FilePresetFactory;
use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use PaymentReport\Plugins\FilePresets\ReportPayment;
use PaymentReport\Services\ReportBuilder;
use PdfServices\Plugins\PdfGenerator\Contracts\PdfGenerable;
use PdfServices\Plugins\PdfGenerator\PdfGeneratorPlugin;

class PaymentReportGeneratorPlugin extends PdfGeneratorPlugin
{
    public function __construct(
        FilePresetFactory $filePresetFactory,
        protected ReportBuilder $builderService,
    ) {
        parent::__construct($filePresetFactory);
    }

    public static function isApplicable(PdfGenerable $model): bool
    {
        return $model instanceof PaymentReportDetailsInterface;
    }

    /**
     * @param PaymentReportDetailsInterface $model
     */
    protected function getData(PdfGenerable $model): array
    {
        $data = $this->builderService->getPaymentData($model);

        return [
            'data' => $data,
            'period' => $this->getPeriodData($model),
            'basis' => $model->getBasisStructureLevel()->getCode(),
        ];
    }

    /**
     * @param PaymentReportDetailsInterface $model
     */
    protected function getFileName(PdfGenerable $model): string
    {
        return "report_payment_{$model->getKey()}";
    }

    protected static function getViewName(): string
    {
        return 'payment_report::report-payment.pdf';
    }

    protected static function getPresetName(): string
    {
        return ReportPayment::NAME;
    }

    private function getPeriodData(PaymentReportDetailsInterface $model): string
    {
        return implode(' - ', [
            $model->getUnGeneratedReport()
                ->getDateFrom()
                ->format('d F, Y'),
            $model->getUnGeneratedReport()
                ->getDateTo()
                ->format('d F, Y'),
        ]);
    }
}
