<?php

namespace PaymentReport\Repositories;

use App\Repositories\BaseDBRepository;
use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Payment\Models\Payment\TransactionData\TransactionData;
use Payment\Models\PaymentSources\Paypoint\Paypoint;
use Payment\Models\PaymentSources\Paypoint\Relations\Contracts\HasCashiersRelationInterface;
use PaymentReport\Models\Enum\ReportBasisCode;
use PaymentReport\Models\Enum\ReportType;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\PaymentReportDetails;
use PaymentReport\Repositories\Contracts\ReportRepositoryInterface;
use PaymentReport\Repositories\Criteria\CustomerPaymentQueryCriteria;
use PaymentReport\Repositories\Criteria\VendorPaymentQueryCriteria;

class ReportRepository extends BaseDBRepository implements ReportRepositoryInterface
{
    public function __construct(private readonly PaymentReport $model)
    {
    }

    protected function getModel(): PaymentReport
    {
        return $this->model;
    }

    public function createReport(array $dates, ?int $userId = null): Model
    {
        return $this->create(array_merge(
            $dates,
            [
                HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID => $userId
            ]
        ));
    }

    public function getReportByIds(array $ids): Collection
    {
        return $this->getQueryBuilder()->findMany($ids);
    }

    // TODO make with criteria in payment_package
    public function getReportDataByReportType(PaymentReportDetails $details, array $reportDates): Collection
    {
        $query = Paypoint::query();

        $criteria = match ($details->getReportType()) {
            ReportType::customer => CustomerPaymentQueryCriteria::class,
            ReportType::vendor => VendorPaymentQueryCriteria::class
        };

        $groupingTemplate = match ($details->getBasisStructureLevel()->getCode()) {
            ReportBasisCode::Regional->value => ['paypoint.id', 'region.id'],
            ReportBasisCode::District->value => ['paypoint.id', 'region.id', 'district.id'],
            default => ['paypoint.id']
        };

        $query->addSelect(
            'paypoint.id',
            'paypoint.name',
            DB::raw("CONCAT(region.region_name, ', ', district.district_name) as location"),
            'paypoint.address',
            'paypoint.email',
            'paypoint.phone_number',
            DB::raw('ROUND(SUM(payment_transaction_data.amount)/100, 2) as payment_total'),
            'paypoint.created_at',
            'region.region_name',
            'district.district_name',
        );

        $this->applyCriterias([new $criteria($details)], $query);
        $query->whereBetween(TransactionData::qualifyAttribute('created_at'), $reportDates);
        $query->withCount(HasCashiersRelationInterface::RELATION_CASHIERS);
        $query->groupBy($groupingTemplate);

        return $query->get();
    }
}
