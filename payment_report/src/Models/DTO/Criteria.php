<?php

declare(strict_types=1);

namespace PaymentReport\Models\DTO;

class Criteria
{
    public const CRITERIA = 'criteria';

    public function __construct(
        public readonly CriteriaData $criteriaData,
        public readonly FrequencyData $frequencyData
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            CriteriaData::fromArray($data[self::CRITERIA]),
            FrequencyData::fromArray($data[FrequencyData::FREQUENCY])
        );
    }
}
