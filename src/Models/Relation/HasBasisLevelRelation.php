<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use App\Models\StructureLevel;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasBasisLevelRelation
{
    public function basisStructureLevel(): HasOne
    {
        return $this->hasOne(StructureLevel::class, 'id', self::ATTRIBUTE_REPORT_BASIS);
    }

    public function getBasisStructureLevel(): StructureLevel
    {
        return $this->getRelationValue(self::RELATION_BASIS_STRUCTURE);
    }
}
