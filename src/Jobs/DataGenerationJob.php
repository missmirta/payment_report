<?php

namespace PaymentReport\Jobs;

use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use App\Queue\Jobs\Job;
use App\Queue\Providers\QueueDefinitionsProvider;
use PaymentReport\Services\Contracts\ReportPaymentFileEnsurerServiceInterface;

class DataGenerationJob extends Job
{
    public function __construct(
        private readonly PaymentReportDetailsInterface $details
    ) {
        return parent::__construct();
    }

    public function handle(ReportPaymentFileEnsurerServiceInterface $fileEnsurerService): void
    {
        $fileEnsurerService->ensureFile($this->details);
    }

    public static function getQueueName(): string
    {
        return QueueDefinitionsProvider::DEFAULT_QUEUE_NAME;
    }
}
