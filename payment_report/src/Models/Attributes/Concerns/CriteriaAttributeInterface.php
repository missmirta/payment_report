<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use PaymentReport\Models\DTO\CriteriaData;

interface CriteriaAttributeInterface
{
    public const ATTRIBUTE_CRITERIA = 'criteria';

    public function getCriteria(): CriteriaData;

    public function setCriteria(CriteriaData $value): static;
}
