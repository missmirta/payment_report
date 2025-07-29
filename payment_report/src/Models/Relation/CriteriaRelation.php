<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use App\Database\Eloquent\RevisionableModelInterface;
use Billing\Models\Tariffs\ServiceCategory\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;
use Payment\Models\PaymentSources\Paypoint\Paypoint;
use Payment\Models\PaymentSources\Vendor\Vendor;

trait CriteriaRelation
{
    public function getVendorIdAttribute(): ?array
    {
        return $this->getCriteria()->getVendors() ?? null;
    }

    public function getVendors(): Collection
    {
        return Vendor::whereIn(
            RevisionableModelInterface::ENTITY_UUID,
            $this->getVendorIdAttribute()
        )->where(RevisionableModelInterface::IS_CURRENT_REVISION, true)->get();
    }

    public function getServiceCategoryUuidAttribute(): ?array
    {
        return $this->getCriteria()->getServiceCategories() ?? null;
    }

    public function getServiceCategories(): Collection
    {
        return ServiceCategory::whereIn(
            RevisionableModelInterface::ENTITY_UUID,
            $this->getServiceCategoryUuidAttribute()
        )->where(RevisionableModelInterface::IS_CURRENT_REVISION, true)->get();
    }

    public function getPaypointIdAttribute(): ?array
    {
        return $this->getCriteria()->getPaypoints() ?? null;
    }

    public function getPaypoints(): Collection
    {
        return Paypoint::whereIn('id', $this->getPaypointIdAttribute())->get();
    }
}
