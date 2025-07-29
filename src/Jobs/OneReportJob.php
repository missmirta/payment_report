<?php

namespace PaymentReport\Jobs;

use Illuminate\Contracts\Foundation\Application;
use PaymentReport\Models\DTO\IntervalData;
use PaymentReport\Models\PaymentReportDetails;
use App\Queue\Providers\QueueDefinitionsProvider;
use PaymentReport\Services\ReportService;
use Processes\Jobs\ProcessJob;
use Processes\Models\Process\Contracts\ProcessInterface;

class OneReportJob extends ProcessJob
{
    private ReportService $reportService;

    public function __construct(
        private readonly PaymentReportDetails $preset,
        private readonly IntervalData $datePeriod,
        ProcessInterface $process,
    ) {
        return parent::__construct($process);
    }

    public function process(): void
    {
        $this->reportService->createReportFromPreset($this->preset, $this->datePeriod);
    }

    public static function getQueueName(): string
    {
        return QueueDefinitionsProvider::DEFAULT_QUEUE_NAME;
    }

    protected function resolveDependencies(Application $app): void
    {
        $this->reportService = $app->make(ReportService::class);
    }
}
