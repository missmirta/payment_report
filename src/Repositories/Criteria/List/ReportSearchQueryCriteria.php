<?php

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\NameAttributeInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

class ReportSearchQueryCriteria implements QueryCriteriaInterface
{
    private string $search;

    public function __construct(string $search)
    {
        $this->search = $search;
    }

    public function apply(Builder $query): Builder
    {
        if (empty($this->search)) {
            return $query;
        }

        $this->addNameCondition($query);

        return $query;
    }

    protected function addNameCondition(Builder $query): void
    {
        $query->where(
            PaymentReportDetails::qualifyAttribute(NameAttributeInterface::ATTRIBUTE_PRESET_NAME),
            'LIKE',
            '%' . $this->search . '%'
        );
    }
}
