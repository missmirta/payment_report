<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes;

use PaymentReport\Models\Enum\ReportType;

trait ReportTypeAttribute
{
    public function initializeReportTypeAttribute(): void
    {
        $this->mergeFillable([
            self::ATTRIBUTE_REPORT_TYPE,
        ]);

        $this->mergeCasts([
            self::ATTRIBUTE_REPORT_TYPE => ReportType::class,
        ]);
    }

    public function getReportType(): ReportType
    {
        return $this->getAttributeValue(self::ATTRIBUTE_REPORT_TYPE);
    }

    public function setReportType(ReportType $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_REPORT_TYPE, $value);

        return $this;
    }
}
