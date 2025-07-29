<?php

declare(strict_types=1);

namespace PaymentReport\Models\DTO;

class FrequencyData
{
    public const FREQUENCY = 'frequency';

    public function __construct(
        private readonly array $frequency,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data[self::FREQUENCY],
        );
    }

    public function toArray(): array
    {
        return [
            self::FREQUENCY => $this->getData(),
        ];
    }

    public function getData(): array
    {
        return $this->frequency;
    }
}
