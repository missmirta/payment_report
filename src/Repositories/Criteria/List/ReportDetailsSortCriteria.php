<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriterias\SortCriteria;
use Illuminate\Database\Eloquent\Builder;

class ReportDetailsSortCriteria extends SortCriteria
{
    public const ALLOWED_SORTING_FIELDS = [
        ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE,
    ];

    public function __construct(string $orderBy, string $order = 'asc')
    {
        if (!in_array($orderBy, self::ALLOWED_SORTING_FIELDS)) {
            $orderBy = '';
        }

        parent::__construct($orderBy, $order);
    }

    public function apply(Builder $query): Builder
    {
        if ($this->orderBy === ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE) {
            $query
                ->orderBy(PaymentReportDetails::qualifyAttribute(
                    ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE
                ), $this->order);
        }

        return $query;
    }
}
