<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use App\Config as Config;
use Illuminate\Support\ServiceProvider;
use PaymentReport\Repositories\Contracts\ReportDetailsRepositoryInterface;
use PaymentReport\Repositories\Contracts\ReportRepositoryInterface;
use PaymentReport\Repositories\ReportDetailsRepository;
use PaymentReport\Repositories\ReportRepository;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ReportDetailsRepositoryInterface::class, ReportDetailsRepository::class);
        $this->app->singleton(ReportRepositoryInterface::class, ReportRepository::class);
    }

    public function boot(): void
    {
    }
}
