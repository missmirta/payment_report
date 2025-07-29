<?php

namespace PaymentReport\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Processes\AutomaticReportGeneration\ProcessData;
use PaymentReport\Providers\ProcessServiceProvider;
use Processes\Repositories\Process\Params\CreateParams;
use Processes\Services\Process\Contracts\ProcessServiceInterface;

class AutomaticReportsGenerationByFrequencyCommand extends Command
{
    protected $signature = 'payment-report:automatic-generation {frequency : Frequency enum}';
    protected $description = 'Generate automatic reports from presets';

    public function handle(ProcessServiceInterface $processService): int
    {
        $frequency = Frequency::tryFrom($this->argument('frequency'));

        if (is_null($frequency)) {
            $this->error('Invalid frequency');

            return 0;
        }

        try {
            $processService->create(CreateParams::make(
                type: ProcessServiceProvider::PROCESS_AUTOMATIC_GENERATION_REPORTS,
                data: ProcessData::make(
                    frequency: $frequency
                ),
            ));
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 0;
        }


        return 1;
    }
}
