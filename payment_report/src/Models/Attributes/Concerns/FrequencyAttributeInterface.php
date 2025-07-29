<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use PaymentReport\Models\DTO\FrequencyData;

interface FrequencyAttributeInterface
{
    public const ATTRIBUTE_FREQUENCY = 'frequency';

    public function getFrequency(): ?FrequencyData;

    public function setFrequency(?FrequencyData $value): static;
}
