<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use App\Queue\Providers\QueueDefinitionsProvider as BaseQueueDefinitionsProvider;
use App\Queue\QueueDefinition;
use App\Queue\QueueDefinitions;
use Illuminate\Support\ServiceProvider;

class QueueDefinitionsProvider extends ServiceProvider
{
    public const QUEUE_NAME = 'payment-report';
    public const LONG_RUNNING_QUEUE_NAME = 'payment-report-long';

    public function register(): void
    {
        QueueDefinitions::register([
            QueueDefinition::make(
                name: self::QUEUE_NAME,
                group: BaseQueueDefinitionsProvider::DEFAULT_QUEUE_GROUP,
            ),
            QueueDefinition::make(
                name: self::LONG_RUNNING_QUEUE_NAME,
                group: BaseQueueDefinitionsProvider::DEFAULT_LONG_RUNNING_QUEUE_GROUP,
            ),
        ]);
    }
}
