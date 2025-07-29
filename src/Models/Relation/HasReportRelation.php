<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\Relation\Contracts\HasFileRelationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasReportRelation
{
    public function report(): HasMany
    {
        return $this->hasMany(PaymentReport::class, self::ATTRIBUTE_DETAILS_ID)
            ->orderBy(Model::CREATED_AT, 'desc');
    }

    public function getReports(): ?Collection
    {
        return $this->getRelationValue(self::RELATION_REPORT);
    }

    public function getReportEntity(): ?PaymentReport
    {
        return $this->getRelationValue(self::RELATION_REPORT)->first();
    }

    public function getUnGeneratedReport(): ?PaymentReport
    {
        return $this->getReports()->whereNull(HasFileRelationInterface::ATTRIBUTE_FILE_ID)->first();
    }
}
