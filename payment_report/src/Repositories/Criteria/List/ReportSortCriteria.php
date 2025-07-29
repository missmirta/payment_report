<?php

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriterias\SortCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReportSortCriteria extends SortCriteria
{
    public const ALLOWED_SORTING_FIELDS = [
        'created_at',
        'report_type',
    ];

    public function __construct(string $orderBy, string $order = 'asc')
    {
        if (!in_array($orderBy, self::ALLOWED_SORTING_FIELDS)) {
            $orderBy = '';
        }

        parent::__construct($orderBy, $order);
    }

    public function apply($query): Builder
    {
        if ($this->orderBy === Model::CREATED_AT) {
            $query->orderBy(PaymentReport::qualifyAttribute(Model::CREATED_AT), $this->order);
        }

        if ($this->orderBy === ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE) {
            $query->orderBy(PaymentReportDetails::qualifyAttribute(
                ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE
            ), $this->order);
        }

        return $query;
    }
}
