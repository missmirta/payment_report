<?php

declare(strict_types=1);

namespace PaymentReport\Models\Casts;

use PaymentReport\Models\DTO\CriteriaData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CriteriaCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (! $value) {
            return null;
        }

        return CriteriaData::fromArray(json_decode($value, true)['criteria']);
    }

    public function set($model, $key, $value, $attributes): string
    {
        return json_encode([$key => $value]);
    }
}
