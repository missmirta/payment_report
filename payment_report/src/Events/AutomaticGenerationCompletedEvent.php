<?php

namespace PaymentReport\Events;

use App\Events\Contracts\EventInterface;
use Processes\Models\Process\Contracts\ProcessInterface;

class AutomaticGenerationCompletedEvent implements EventInterface
{
    public function __construct(
        protected readonly ProcessInterface $process
    ) {
    }

    public function getProcess(): ProcessInterface
    {
        return $this->process;
    }
}
