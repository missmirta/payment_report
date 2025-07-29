<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria;

use Account\Models\Account;
use Account\Models\AccountInterface;
use Account\Models\AccountPaymentAccountInterface;
use App\Models\Clusters\Contracts\DistrictInterface;
use App\Models\Clusters\Contracts\RegionInterface;
use App\Models\Concerns\ServiceCategory\HasServiceCategoryRelationInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Payment\Models\Payment\TransactionData\Contracts\TransactionDataInterface;
use Payment\Models\Payment\TransactionData\Enums\StatusEnum;
use Payment\Models\Payment\TransactionData\TransactionData;
use Payment\Models\PaymentSources\Paypoint\Contracts\PaypointCashierPivotInterface;
use Payment\Models\PaymentSources\Paypoint\Contracts\PaypointInterface;
use Payment\Models\PaymentSources\Paypoint\Paypoint;
use Transactions\Models\PaymentAccount\PaymentAccountInterface;

class CustomerPaymentQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly PaymentReportDetails $details
    ) {
    }

    public function apply(Builder $query): Builder
    {
        $query->leftJoin(
            PaypointCashierPivotInterface::TABLE,
            PaypointCashierPivotInterface::TABLE . '.paypoint_id',
            PaypointInterface::TABLE . '.id'
        );

        $query->leftJoin(
            TransactionDataInterface::TABLE,
            PaypointCashierPivotInterface::TABLE . '.user_id',
            TransactionDataInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_ISSUER_ID
        );

        $query->leftJoin(
            PaymentAccountInterface::TABLE,
            TransactionDataInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_PAYMENT_ACCOUNT_ID,
            PaymentAccountInterface::TABLE . '.id'
        );

        $query->where(
            PaymentAccountInterface::TABLE . '.' . PaymentAccountInterface::ATTRIBUTE_TYPE,
            PaymentAccountInterface::TYPE_ACCOUNT
        )->where(
            TransactionDataInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_STATUS,
            StatusEnum::DONE->value
        );

        $query->leftJoin(
            AccountPaymentAccountInterface::TABLE,
            AccountPaymentAccountInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_PAYMENT_ACCOUNT_ID,
            PaymentAccountInterface::TABLE . '.id'
        );

        $query->leftJoin(
            AccountInterface::TABLE,
            AccountInterface::TABLE . '.id',
            AccountPaymentAccountInterface::TABLE . '.' . AccountPaymentAccountInterface::ATTRIBUTE_ACCOUNT_ID
        );

        $query->leftJoin(
            RegionInterface::TABLE,
            RegionInterface::TABLE . '.id',
            PaypointInterface::TABLE . '.region_id'
        );

        $query->leftJoin(
            DistrictInterface::TABLE,
            DistrictInterface::TABLE . '.id',
            PaypointInterface::TABLE . '.district_id'
        );

        if (!empty($regions = $this->details->getCriteria()->getRegions())) {
            $query->whereIn(Paypoint::qualifyAttribute('region_id'), $regions);
        }

        if (!empty($districts = $this->details->getCriteria()->getDistricts())) {
            $query->whereIn(Paypoint::qualifyAttribute('district_id'), $districts);
        }

        if (!empty($categories = $this->details->getCriteria()->getServiceCategories())) {
            $query->whereIn(Account::qualifyAttribute(
                HasServiceCategoryRelationInterface::ATTRIBUTE_SERVICE_CATEGORY_UUID
            ), $categories);
        }

        if (!empty($paypoints = $this->details->getCriteria()->getPaypoints())) {
            $query->whereIn(Paypoint::qualifyAttribute('id'), $paypoints);
        }

        if (!empty($methods = $this->details->getCriteria()->getPaymentMethods())) {
            $query->whereIn(
                TransactionData::qualifyAttribute(TransactionDataInterface::ATTRIBUTE_METHOD),
                $methods
            );
        }

        return $query;
    }
}
