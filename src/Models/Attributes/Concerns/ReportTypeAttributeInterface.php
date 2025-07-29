<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use PaymentReport\Models\Enum\ReportType;

interface ReportTypeAttributeInterface
{
    public const ATTRIBUTE_REPORT_TYPE = 'report_type';

    public function getReportType(): ReportType;

    public function setReportType(ReportType $value): static;
}
