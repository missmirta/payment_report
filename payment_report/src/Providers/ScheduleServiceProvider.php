<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use PaymentReport\Console\Commands\AutomaticReportsGenerationByFrequencyCommand;
use PaymentReport\Models\Enum\Frequency;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->schedulePaymentReportCreation($schedule);
        });
    }

    protected function schedulePaymentReportCreation(Schedule $schedule): void
    {
        $schedule
            ->command(AutomaticReportsGenerationByFrequencyCommand::class, [Frequency::daily->value])
            ->daily();

        $schedule
            ->command(AutomaticReportsGenerationByFrequencyCommand::class, [Frequency::weekly->value])
            ->weekly();

        $schedule
            ->command(AutomaticReportsGenerationByFrequencyCommand::class, [Frequency::monthly->value])
            ->monthly();
    }
}
