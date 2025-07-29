<?php

declare(strict_types=1);

namespace PaymentReport\Models\Casts;

use PaymentReport\Models\DTO\FrequencyData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class FrequencyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (! $value) {
            return null;
        }

        return FrequencyData::fromArray(json_decode($value, true));
    }

    public function set($model, $key, $value, $attributes): string
    {
        return json_encode([$key => $value]);
    }
}
