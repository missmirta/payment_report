<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

trait BasisAttribute
{
    public function initializeBasisAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_REPORT_BASIS,
        ]);
    }

    public function getBasis(): int
    {
        return $this->getAttributeValue(self::ATTRIBUTE_REPORT_BASIS);
    }

    public function setBasis(int $value): self
    {
        $this->setAttribute(self::ATTRIBUTE_REPORT_BASIS, $value);

        return $this;
    }
}
