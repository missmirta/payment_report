<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use Carbon\Carbon;

trait DateFromAttribute
{
    public function initializeDateFromAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_DATE_FROM,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_DATE_FROM => 'date',
        ]);
    }

    public function getDateFrom(): Carbon
    {
        return $this->getAttributeValue(self::ATTRIBUTE_DATE_FROM);
    }

    public function setDateFrom(Carbon $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_DATE_FROM, $value);

        return $this;
    }

    public function getReportDates(): array
    {
        return [$this->getDateFrom(), $this->getDateTo()];
    }
}
