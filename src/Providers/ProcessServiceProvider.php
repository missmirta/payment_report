<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use Illuminate\Support\ServiceProvider;
use PaymentReport\Processes\AutomaticReportGeneration as AutomaticReportGeneration;
use PaymentReport\Processes\DownloadReport as DownloadReport;
use Processes\Models\Process\ProcessType;
use Processes\Models\Process\ProcessTypes;

class ProcessServiceProvider extends ServiceProvider
{
    public const PROCESS_DOWNLOAD_PAYMENT_REPORTS = 'payment_reports.download';
    public const PROCESS_AUTOMATIC_GENERATION_REPORTS = 'payment_reports.automatic_generation';

    public function boot(): void
    {
        ProcessTypes::register([
            ProcessType::make(
                name: self::PROCESS_DOWNLOAD_PAYMENT_REPORTS,
                jobsProducerClass: DownloadReport\JobsProducer::class,
                dataValueObjectClass: DownloadReport\ProcessData::class,
                completionHandlerClass: DownloadReport\CompletionHandler::class,
                queue: QueueDefinitionsProvider::QUEUE_NAME,
            ),
            ProcessType::make(
                name: self::PROCESS_AUTOMATIC_GENERATION_REPORTS,
                jobsProducerClass: AutomaticReportGeneration\JobsProducer::class,
                dataValueObjectClass: AutomaticReportGeneration\ProcessData::class,
                completionHandlerClass: AutomaticReportGeneration\CompletionHandler::class,
                queue: QueueDefinitionsProvider::QUEUE_NAME,
            ),
        ]);
    }
}
