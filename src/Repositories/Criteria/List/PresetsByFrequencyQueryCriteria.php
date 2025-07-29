<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Enum\Frequency;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class PresetsByFrequencyQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly Frequency $frequency,
    ) {
    }

    public function apply(Builder $query): Builder
    {
        $query->whereJsonContains('frequency->frequency', $this->frequency->value);

        return $query;
    }
}
