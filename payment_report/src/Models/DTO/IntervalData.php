<?php

declare(strict_types=1);

namespace PaymentReport\Models\DTO;

use PaymentReport\Models\Attributes\Concerns\DateFromAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\DateToAttributeInterface;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class IntervalData
{
    public function __construct(
        protected readonly CarbonPeriod $dateInterval
    ) {
    }

    public static function make(CarbonPeriod $dateInterval): static
    {
        return new static($dateInterval);
    }

    public function toArray(): array
    {
        return [
            DateFromAttributeInterface::ATTRIBUTE_DATE_FROM => $this->getFrom(),
            DateToAttributeInterface::ATTRIBUTE_DATE_TO => $this->getTo(),
        ];
    }

    public function getFrom(): CarbonInterface
    {
        return $this->dateInterval->getStartDate();
    }

    public function getTo(): CarbonInterface
    {
        return $this->dateInterval->getEndDate();
    }
}
