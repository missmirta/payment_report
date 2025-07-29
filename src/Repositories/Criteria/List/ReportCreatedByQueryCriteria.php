<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use PaymentReport\Repositories\Criteria\List\Params\ReportManualListParams;

class ReportCreatedByQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly ReportManualListParams $params
    ) {
    }

    public function apply(Builder $query): Builder
    {
        if (!is_null($this->params->createdById)) {
            $this->addCreatedByCondition($query);
        }

        return $query;
    }

    private function addCreatedByCondition(Builder $query): void
    {
        $query->where(
            PaymentReport::qualifyAttribute(HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID),
            $this->params->createdById
        );
    }
}
