<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Support\ServiceProvider;
use PaymentReport\Services\Contracts\ReportPaymentFileEnsurerServiceInterface;
use PaymentReport\Services\ReportPaymentFileEnsurerService;

class ServicesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ReportPaymentFileEnsurerServiceInterface::class, ReportPaymentFileEnsurerService::class);
    }
}
