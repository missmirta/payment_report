<?php

declare(strict_types=1);

namespace PaymentReport\Processes\AutomaticReportGeneration;

use App\Models\Casts\CastableJsonValue;
use App\Models\Casts\CastableJsonValueInterface;
use InvalidArgumentException;
use PaymentReport\Models\Enum\Frequency;

final class ProcessData extends CastableJsonValue implements CastableJsonValueInterface
{
    private function __construct(
        private readonly Frequency $frequency,
    ) {
    }

    public static function make(Frequency $frequency): self
    {
        return new self($frequency);
    }

    public function toArray(): array
    {
        return [
            'frequency' => $this->frequency->value,
        ];
    }

    public static function fromArray(array $parameters): static
    {
        if (!isset($parameters['frequency'])) {
            throw new InvalidArgumentException('Missing required parameter: frequency');
        }

        return new self(Frequency::tryFrom($parameters['frequency']));
    }

    public function getFrequency(): Frequency
    {
        return $this->frequency;
    }
}
