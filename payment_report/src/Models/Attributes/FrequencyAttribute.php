<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use PaymentReport\Models\Casts\FrequencyCast;
use PaymentReport\Models\DTO\FrequencyData;

trait FrequencyAttribute
{
    public function initializeFrequencyAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_FREQUENCY,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_FREQUENCY => FrequencyCast::class,
        ]);
    }

    public function getFrequency(): ?FrequencyData
    {
        return $this->getAttributeValue(self::ATTRIBUTE_FREQUENCY);
    }

    public function setFrequency(?FrequencyData $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_FREQUENCY, $value);

        return $this;
    }
}
