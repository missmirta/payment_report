<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Builder;

class PresetTypeQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly GenerationTypeName $type,
    ) {
    }

    public function apply(Builder $query): Builder
    {
        $query->where(
            PaymentReportDetails::qualifyAttribute(GenerationTypeAttributeInterface::ATTRIBUTE_GENERATION_TYPE),
            $this->type->value
        );

        return $query;
    }
}
