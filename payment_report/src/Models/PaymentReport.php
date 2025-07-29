<?php

declare(strict_types=1);

namespace PaymentReport\Models;

use App\Models\Concerns\Common\QualifiableAttributes;
use App\Models\Concerns\HasPrimaryKeyUuid;
use PaymentReport\Models\Contracts\PaymentReportInterface;
use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasDetailsRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasFileRelationInterface;
use PaymentReport\Models\Relation\HasCreatedByRelation;
use PaymentReport\Models\Relation\HasDetailsRelation;
use PaymentReport\Models\Relation\HasFileRelation;
use PaymentReport\Models\Attributes\DateFromAttribute;
use PaymentReport\Models\Attributes\DateToAttribute;
use Illuminate\Database\Eloquent\Model;

class PaymentReport extends Model implements PaymentReportInterface
{
    use QualifiableAttributes;
    use HasPrimaryKeyUuid;

    // attributes
    use DateFromAttribute;
    use DateToAttribute;

    // relations
    use HasDetailsRelation;
    use HasFileRelation;
    use HasCreatedByRelation;

    protected $fillable = [
        HasDetailsRelationInterface::ATTRIBUTE_DETAILS_ID,
        HasFileRelationInterface::ATTRIBUTE_FILE_ID,
        HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID
    ];

    protected $table = self::TABLE;
}
