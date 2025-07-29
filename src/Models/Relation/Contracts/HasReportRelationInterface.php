<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation\Contracts;

use PaymentReport\Models\PaymentReport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface HasReportRelationInterface
{
    public const RELATION_REPORT = 'report';
    public const ATTRIBUTE_DETAILS_ID = 'details_id';
    public function report(): HasMany;
    public function getReports(): ?Collection;
    public function getUnGeneratedReport(): ?PaymentReport;
}
