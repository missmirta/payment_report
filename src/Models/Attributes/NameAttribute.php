<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

trait NameAttribute
{
    public function initializeNameAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_PRESET_NAME,
        ]);
    }

    public function getName(): string
    {
        return $this->getAttributeValue(self::ATTRIBUTE_PRESET_NAME);
    }

    public function setName(string $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_PRESET_NAME, $value);

        return $this;
    }
}
