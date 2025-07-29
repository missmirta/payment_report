<?php

declare(strict_types=1);

namespace PaymentReport\Models;

use App\Models\Concerns\Common\QualifiableAttributes;
use App\Models\Concerns\HasPrimaryKeyUuid;
use PaymentReport\Models\Attributes\BasisAttribute;
use PaymentReport\Models\Attributes\CriteriaAttribute;
use PaymentReport\Models\Attributes\FrequencyAttribute;
use PaymentReport\Models\Attributes\GenerationTypeAttribute;
use PaymentReport\Models\Attributes\NameAttribute;
use PaymentReport\Models\Attributes\ReportTypeAttribute;
use PaymentReport\Models\Contracts\PaymentReportDetailsInterface;
use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use PaymentReport\Models\Relation\CriteriaRelation;
use PaymentReport\Models\Relation\HasBasisLevelRelation;
use PaymentReport\Models\Relation\HasCreatedByRelation;
use PaymentReport\Models\Relation\HasReportRelation;
use PaymentReport\Observers\DefaultObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReportDetails extends Model implements PaymentReportDetailsInterface
{
    use SoftDeletes;

    // attributes
    use HasPrimaryKeyUuid;
    use QualifiableAttributes;
    use BasisAttribute;
    use GenerationTypeAttribute;
    use ReportTypeAttribute;
    use NameAttribute;
    use FrequencyAttribute;
    use CriteriaAttribute;

    // relation
    use HasCreatedByRelation;
    use HasReportRelation;
    use HasBasisLevelRelation;
    use CriteriaRelation;

    protected $fillable = [
        HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID
    ];

    protected $table = self::TABLE;

    public static function boot(): void
    {
        parent::boot();
        self::observe(DefaultObserver::class);
    }
}
