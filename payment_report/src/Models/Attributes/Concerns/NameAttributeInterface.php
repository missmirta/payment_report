<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

interface NameAttributeInterface
{
    public const ATTRIBUTE_PRESET_NAME = 'name';
    public function getName(): string;
    public function setName(string $value): static;
}
