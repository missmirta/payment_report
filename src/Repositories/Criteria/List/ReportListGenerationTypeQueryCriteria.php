<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use PaymentReport\Models\Contracts\PaymentReportInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Builder;

class ReportListGenerationTypeQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(private readonly GenerationTypeName $type)
    {
    }

    public function apply(Builder $query): Builder
    {
        $query->leftJoin(
            PaymentReportDetailsInterface::TABLE,
            PaymentReportDetailsInterface::TABLE . '.id',
            PaymentReportInterface::TABLE . '.details_id'
        );

        $this->listByGenerationType($query);

        return $query;
    }

    private function listByGenerationType(Builder $query): void
    {
        $query->where(
            PaymentReportDetails::qualifyAttribute(GenerationTypeAttributeInterface::ATTRIBUTE_GENERATION_TYPE),
            $this->type->value
        );
    }
}
