<?php

declare(strict_types=1);

namespace PaymentReport\Actions\Contracts;

use PaymentReport\Models\Contracts\PaymentReportInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface FindPaymentReportByFileActionInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function handle(string $fileId): PaymentReportInterface;
}
