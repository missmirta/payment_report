<?php

namespace PaymentReport\Models\Contracts;

use PaymentReport\Models\Attributes\Concerns\BasisAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\CriteriaAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\CriteriaRelationInterface;
use PaymentReport\Models\Attributes\Concerns\FrequencyAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\NameAttributeInterface;
use PaymentReport\Models\Relation\Contracts\HasBasisLevelRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasCreatedByRelationInterface;
use PaymentReport\Models\Relation\Contracts\HasReportRelationInterface;
use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PdfServices\Plugins\PdfGenerator\Contracts\PdfGenerable;

interface PaymentReportDetailsInterface extends
    PdfGenerable,
    BasisAttributeInterface,
    HasCreatedByRelationInterface,
    HasReportRelationInterface,
    GenerationTypeAttributeInterface,
    ReportTypeAttributeInterface,
    NameAttributeInterface,
    HasBasisLevelRelationInterface,
    FrequencyAttributeInterface,
    CriteriaAttributeInterface,
    CriteriaRelationInterface
{
    public const TABLE = 'payment_report_details';
}
