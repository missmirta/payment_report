<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria;

use App\Database\Eloquent\RevisionableModelInterface;
use App\Models\Clusters\Contracts\DistrictInterface;
use App\Models\Clusters\Contracts\RegionInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;
use Payment\Models\Payment\TransactionData\Contracts\TransactionDataInterface;
use Payment\Models\Payment\TransactionData\Enums\StatusEnum;
use Payment\Models\Payment\TransactionData\TransactionData;
use Payment\Models\PaymentSources\Paypoint\Contracts\PaypointCashierPivotInterface;
use Payment\Models\PaymentSources\Paypoint\Contracts\PaypointInterface;
use Payment\Models\PaymentSources\Paypoint\Paypoint;
use Payment\Models\PaymentSources\Vendor\Contracts\VendorInterface;
use Payment\Models\PaymentSources\Vendor\Vendor;
use Payment\Models\PaymentSources\Vendor\VendorPaymentAccount\Contracts\VendorPaymentAccountInterface;
use Transactions\Models\PaymentAccount\PaymentAccountInterface;

class VendorPaymentQueryCriteria implements QueryCriteriaInterface
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
            PaymentAccountInterface::TYPE_VENDOR
        )->where(
            TransactionDataInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_STATUS,
            '=',
            StatusEnum::DONE->value
        );

        $query->leftJoin(
            VendorPaymentAccountInterface::TABLE,
            VendorPaymentAccountInterface::TABLE . '.' . TransactionDataInterface::ATTRIBUTE_PAYMENT_ACCOUNT_ID,
            PaymentAccountInterface::TABLE . '.id'
        )->where(RevisionableModelInterface::IS_CURRENT_REVISION, true);

        $query->leftJoin(
            VendorInterface::TABLE,
            VendorInterface::TABLE . '.entity_uuid',
            VendorPaymentAccountInterface::TABLE . '.' . VendorPaymentAccountInterface::ATTRIBUTE_VENDOR_UUID
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

        if (!empty($vendors = $this->details->getCriteria()->getVendors())) {
            $query->whereIn(Vendor::qualifyAttribute('entity_uuid'), $vendors);
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
