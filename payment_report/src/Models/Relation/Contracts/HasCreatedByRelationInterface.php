<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasCreatedByRelationInterface
{
    public const RELATION_CREATED_BY = 'createdBy';
    public const ATTRIBUTE_CREATED_BY_ID = 'created_by_id';

    public function createdBy(): BelongsTo;

    public function getCreatedBy(): ?User;

    public function getCreatedById(): ?int;

    public function setCreatedBy(?int $value): static;
}
