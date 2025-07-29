<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use Illuminate\Database\Eloquent\Collection;

interface CriteriaRelationInterface
{
    public function getVendorIdAttribute(): ?array;
    public function getVendors(): Collection;
    public function getServiceCategoryUuidAttribute(): ?array;
    public function getServiceCategories(): Collection;
    public function getPaypointIdAttribute(): ?array;
    public function getPaypoints(): Collection;
}
