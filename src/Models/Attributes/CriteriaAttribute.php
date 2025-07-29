<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use PaymentReport\Models\Casts\CriteriaCast;
use PaymentReport\Models\DTO\CriteriaData;

trait CriteriaAttribute
{
    public function initializeCriteriaAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_CRITERIA,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_CRITERIA => CriteriaCast::class,
        ]);
    }

    public function getCriteria(): CriteriaData
    {
        return $this->getAttributeValue(self::ATTRIBUTE_CRITERIA);
    }

    public function setCriteria(CriteriaData $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_CRITERIA, $value);

        return $this;
    }
}
