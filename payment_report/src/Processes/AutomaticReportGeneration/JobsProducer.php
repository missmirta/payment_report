<?php

declare(strict_types=1);

namespace PaymentReport\Processes\AutomaticReportGeneration;

use PaymentReport\Jobs\OneReportJob;
use PaymentReport\Models\DTO\IntervalData;
use PaymentReport\Models\PaymentReportDetails;
use PaymentReport\Services\ReportService;
use Processes\Models\Process\Contracts\ProcessInterface;
use Processes\Process\JobsProducers\Contracts\JobsProducerInterface;

class JobsProducer implements JobsProducerInterface
{
    public function __construct(
        private readonly ReportService $service,
    ) {
    }

    public function getJobs(ProcessInterface $process): array
    {
        /** @var ProcessData $data */
        $data = $process->getData();
        $frequency = $data->getFrequency();
        $dateDto = IntervalData::make($frequency->getDateInterval());

        return array_map(
            function (PaymentReportDetails $preset) use ($dateDto, $process): OneReportJob {
                return new OneReportJob($preset, $dateDto, $process);
            },
            $this->service->getAutomaticPresets($frequency)->all()
        );
    }
}
