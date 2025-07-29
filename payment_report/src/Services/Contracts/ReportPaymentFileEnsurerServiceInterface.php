<?php

declare(strict_types=1);

namespace PaymentReport\Services\Contracts;

use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;

interface ReportPaymentFileEnsurerServiceInterface
{
    public function ensureFile(PaymentReportDetailsInterface $paymentReportDetails): void;
}
