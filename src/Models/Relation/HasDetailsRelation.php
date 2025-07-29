<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use PaymentReport\Models\PaymentReportDetails;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasDetailsRelation
{
    public function details(): BelongsTo
    {
        return $this
            ->belongsTo(PaymentReportDetails::class, self::ATTRIBUTE_DETAILS_ID)
            ->withTrashed();
    }

    public function getDetails(): PaymentReportDetails
    {
        return $this->getRelationValue(self::RELATION_DETAILS);
    }

    public function setDetails(string $detailsId): self
    {
        $this->setAttribute(self::ATTRIBUTE_DETAILS_ID, $detailsId);

        return $this;
    }
}
