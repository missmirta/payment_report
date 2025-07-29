<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation\Contracts;

use App\Models\StructureLevel;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface HasBasisLevelRelationInterface
{
    public const RELATION_BASIS_STRUCTURE = 'basisStructureLevel';
    public function basisStructureLevel(): HasOne;
    public function getBasisStructureLevel(): StructureLevel;
}
