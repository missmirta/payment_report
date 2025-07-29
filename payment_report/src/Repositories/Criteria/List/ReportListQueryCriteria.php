<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\BasisAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use PaymentReport\Repositories\Criteria\List\Params\ReportAutomaticListParams;
use PaymentReport\Repositories\Criteria\List\Params\ReportManualListParams;

class ReportListQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly ReportAutomaticListParams|ReportManualListParams $params
    ) {
    }

    public function apply(Builder $query): Builder
    {
        if (!is_null($this->params->reportType)) {
            $this->addReportTypeCondition($query);
        }

        if (!is_null($this->params->reportBasis)) {
            $this->addReportBasisCondition($query);
        }

        return $query;
    }

    private function addReportTypeCondition(Builder $query): void
    {
        $query->whereIn(
            PaymentReportDetails::qualifyAttribute(ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE),
            $this->params->reportType
        );
    }

    private function addReportBasisCondition(Builder $query): void
    {
        $query->whereIn(
            PaymentReportDetails::qualifyAttribute(BasisAttributeInterface::ATTRIBUTE_REPORT_BASIS),
            $this->params->reportBasis
        );
    }
}
