<?php

namespace PaymentReport\Models\Contracts;

use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasDetailsRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasFileRelationInterface;
use PaymentReport\Models\Attributes\Concerns\DateFromAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\DateToAttributeInterface;

interface PaymentReportInterface extends
    HasDetailsRelationInterface,
    HasFileRelationInterface,
    HasCreatedByRelationInterface,
    DateFromAttributeInterface,
    DateToAttributeInterface
{
    public const TABLE = 'payment_report';
}
