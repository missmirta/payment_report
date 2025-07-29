<?php

namespace PaymentReport\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Processes\Models\Process\Contracts\ProcessInterface;

class PaymentReportProcessCompletedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(protected readonly ProcessInterface $process)
    {
    }

    public function getProcess(): ProcessInterface
    {
        return $this->process;
    }
}
