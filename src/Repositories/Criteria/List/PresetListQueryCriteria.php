<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List;

use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\Attributes\Concerns\NameAttributeInterface;
use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\Common\QueryCriteriaInterface;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Builder;
use PaymentReport\Repositories\Criteria\List\Params\ReportPresetListParams;

class PresetListQueryCriteria implements QueryCriteriaInterface
{
    public function __construct(
        private readonly GenerationTypeName $type,
        private readonly ReportPresetListParams $params
    ) {
    }

    public function apply(Builder $query): Builder
    {
        $this->addGenerationTypeCondition($query);

        if (!is_null($this->params->search)) {
            $this->searchByPresetName($query);
        }

        return $query;
    }

    private function addGenerationTypeCondition(Builder $query): void
    {
        $query->where(
            PaymentReportDetails::qualifyAttribute(GenerationTypeAttributeInterface::ATTRIBUTE_GENERATION_TYPE),
            $this->type->value
        );
    }

    private function searchByPresetName(Builder $query): void
    {
        $query->where(
            PaymentReportDetails::qualifyAttribute(NameAttributeInterface::ATTRIBUTE_PRESET_NAME),
            'like',
            '%' . $this->params->search . '%'
        );
    }
}
