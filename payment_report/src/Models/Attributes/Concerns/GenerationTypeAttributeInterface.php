<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use PaymentReport\Models\Enum\GenerationTypeName;

interface GenerationTypeAttributeInterface
{
    public const ATTRIBUTE_GENERATION_TYPE = 'type';

    public function getType(): GenerationTypeName;

    public function setType(GenerationTypeName $value): static;
}
