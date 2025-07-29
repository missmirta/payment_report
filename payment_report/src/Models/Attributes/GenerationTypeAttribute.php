<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use PaymentReport\Models\Enum\GenerationTypeName;

trait GenerationTypeAttribute
{
    public function initializeGenerationTypeAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_GENERATION_TYPE,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_GENERATION_TYPE => GenerationTypeName::class,
        ]);
    }

    public function getType(): GenerationTypeName
    {
        return $this->getAttributeValue(self::ATTRIBUTE_GENERATION_TYPE);
    }

    public function setType(GenerationTypeName $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_GENERATION_TYPE, $value);

        return $this;
    }
}
