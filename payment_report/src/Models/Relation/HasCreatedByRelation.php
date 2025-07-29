<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCreatedByRelation
{
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_CREATED_BY_ID);
    }

    public function getCreatedBy(): ?User
    {
        return $this->getRelationValue(self::RELATION_CREATED_BY);
    }

    public function getCreatedById(): ?int
    {
        return $this->getAttributeValue(self::ATTRIBUTE_CREATED_BY_ID);
    }

    public function setCreatedBy(?int $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_CREATED_BY_ID, $value);

        return $this;
    }
}
