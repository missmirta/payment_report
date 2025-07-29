<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Support\ServiceProvider;
use PaymentReport\PdfGenerator\PaymentReportGeneratorPlugin;

class PdfGeneratorPluginsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag(PaymentReportGeneratorPlugin::class, 'pdf-generator');
    }
}
