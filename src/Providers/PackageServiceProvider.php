<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public static string $packageName = 'payment_report';

    public function register(): void
    {
        $this->app->register(RoutesServiceProvider::class);
        $this->app->register(QueueDefinitionsProvider::class);
        $this->app->register(ProcessServiceProvider::class);
        $this->app->register(PdfGeneratorPluginsServiceProvider::class);
        $this->app->register(RepositoriesServiceProvider::class);
        $this->app->register(ServicesServiceProvider::class);
        $this->app->register(ScheduleServiceProvider::class);
        $this->app->register(CommandsServiceProvider::class);
        $this->app->register(PluginsServiceProvider::class);
        $this->app->register(ActionsServiceProvider::class);
    }

    public function boot(): void
    {
        $this->registerConfigs();
    }

    protected function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/swagger-documentation.php', 'l5-swagger.documentations');
    }
}
