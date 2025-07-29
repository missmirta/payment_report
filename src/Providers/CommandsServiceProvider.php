<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Support\ServiceProvider;
use PaymentReport\Console\Commands\AutomaticReportsGenerationByFrequencyCommand;

class CommandsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            AutomaticReportsGenerationByFrequencyCommand::class,
        ]);
    }
}
