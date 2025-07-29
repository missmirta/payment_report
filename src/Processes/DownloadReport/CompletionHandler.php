<?php

declare(strict_types=1);

namespace PaymentReport\Processes\DownloadReport;

use Illuminate\Contracts\Events\Dispatcher;
use PaymentReport\Events\PaymentReportProcessCompletedEvent;
use Processes\Models\Process\Contracts\ProcessInterface;
use Processes\Process\CompletionHandlers\Contracts\CompletionHandlerInterface;

class CompletionHandler implements CompletionHandlerInterface
{
    public function __construct(private readonly Dispatcher $eventDispatcher)
    {
    }

    public function handle(ProcessInterface $process): void
    {
        $this->eventDispatcher->dispatch(new PaymentReportProcessCompletedEvent($process));
    }
}
