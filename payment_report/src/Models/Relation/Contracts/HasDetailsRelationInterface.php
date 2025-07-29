<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation\Contracts;

use PaymentReport\Models\PaymentReportDetails;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasDetailsRelationInterface
{
    public const RELATION_DETAILS = 'details';
    public const ATTRIBUTE_DETAILS_ID = 'details_id';

    public function details(): BelongsTo;

    public function getDetails(): PaymentReportDetails;
    public function setDetails(string $detailsId): self;
}
