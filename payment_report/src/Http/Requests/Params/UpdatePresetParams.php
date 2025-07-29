<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests\Params;

use PaymentReport\Models\Attributes\Concerns\BasisAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\CriteriaAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\FrequencyAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\ReportTypeAttributeInterface;
use PaymentReport\Models\DTO\CriteriaData;
use PaymentReport\Models\DTO\FrequencyData;
use PaymentReport\Models\Enum\ReportType;
use Survey\Models\Relations\Contracts\HasCreatedByRelationInterface;

class UpdatePresetParams
{
    protected function __construct(
        public readonly int $reportBasis,
        public readonly ReportType $reportType,
        public readonly int $createdById,
        public readonly CriteriaData $criteriaData,
        public readonly FrequencyData $frequencyData
    ) {
    }

    public static function make(
        int $reportBasis,
        ReportType $reportType,
        int $createdById,
        CriteriaData $criteriaData,
        FrequencyData $frequencyData
    ): static {
        return new static(
            $reportBasis,
            $reportType,
            $createdById,
            $criteriaData,
            $frequencyData
        );
    }

    public function getPresetAttributes(): array
    {
        return [
                BasisAttributeInterface::ATTRIBUTE_REPORT_BASIS => $this->getReportBasis(),
                ReportTypeAttributeInterface::ATTRIBUTE_REPORT_TYPE => $this->getReportType()->value,
                HasCreatedByRelationInterface::ATTRIBUTE_CREATED_BY_ID => $this->getCreatedById(),
                FrequencyAttributeInterface::ATTRIBUTE_FREQUENCY => $this->getFrequencyData()->getData(),
            ] + $this->getCriteriaData();
    }

    public function getCriteriaData(): array
    {
        return [CriteriaAttributeInterface::ATTRIBUTE_CRITERIA => $this->criteriaData->toArray()];
    }

    public function getReportBasis(): int
    {
        return $this->reportBasis;
    }

    public function getReportType(): ReportType
    {
        return $this->reportType;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function getFrequencyData(): FrequencyData
    {
        return $this->frequencyData;
    }
}
