<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\PaymentReportDetails;

use function ltrim;

class RoutesServiceProvider extends ServiceProvider
{
    protected const ROUTES_FILES_MAP = [
        'api' => [
            // With prefix
            'payment-reports' => 'api/payment-reports.php',
        ],
    ];

    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->routeOptions(['supported' => true])
                ->group($this->mapApiV1Routes(...));
        });

        $this->registerViews();
        $this->bindModels();
        $this->bindParams();
    }

    protected function bindModels(): void
    {
        Route::model('paymentReport', PaymentReport::class);
        Route::model('paymentReportPreset', PaymentReportDetails::class);
    }

    protected function bindParams(): void
    {
        // Bind params
    }

    protected function mapApiV1Routes(): void
    {
        Route::prefix('v1')
            ->group(function () {
                foreach (self::ROUTES_FILES_MAP['api'] as $prefix => $filePath) {
                    if (is_string($prefix)) {
                        Route::prefix($prefix)
                            ->group($this->getRotesFullFilePath($filePath));
                    } else {
                        Route::group([], $this->getRotesFullFilePath($filePath));
                    }
                }
            });
    }

    private function getRotesFullFilePath(string $filePath): string
    {
        $filePath = ltrim($filePath, '/');

        return base_path() . "/packages/app/payment_report/routes/$filePath";
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views',
            'payment_report'
        );
    }
}
