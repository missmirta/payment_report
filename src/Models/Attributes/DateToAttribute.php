<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use Carbon\Carbon;

trait DateToAttribute
{
    public function initializeDateToAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_DATE_TO,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_DATE_TO => 'date',
        ]);
    }

    public function getDateTo(): Carbon
    {
        return $this->getAttributeValue(self::ATTRIBUTE_DATE_TO);
    }

    public function setDateTo(Carbon $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_DATE_TO, $value);

        return $this;
    }
}
