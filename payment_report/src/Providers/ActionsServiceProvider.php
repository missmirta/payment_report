<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use PaymentReport\Actions\Contracts\FindPaymentReportByFileActionInterface;
use PaymentReport\Actions\FindPaymentReportByFileAction;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FindPaymentReportByFileActionInterface::class, FindPaymentReportByFileAction::class);
    }
}
