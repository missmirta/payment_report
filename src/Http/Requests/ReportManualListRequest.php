<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use App\Http\Requests\Common\PaginatableParams;
use App\Http\Requests\Common\PaginatableRequestParamsTrait;
use App\Http\Requests\Common\SearchableRequestParamsTrait;
use App\Http\Requests\Common\SortableParams;
use App\Http\Requests\Common\SortableRequestParamsTrait;
use App\Rules\Decorated\IsInteger;
use PaymentReport\Models\Enum\ReportType;
use App\Models\StructureLevel;
use App\Models\User;
use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use PaymentReport\Repositories\Criteria\List\Params\ReportManualListParams;

class ReportManualListRequest extends FormRequest implements SortableParams, PaginatableParams
{
    use PaginatableRequestParamsTrait;
    use SortableRequestParamsTrait;
    use SearchableRequestParamsTrait;

    private ReportManualListParams $params;

    public function rules(): array
    {
        return [
            'report_type' => [
                'array',
            ],
            'report_type.*' => [
                'string',
                Rule::in(ReportType::toArraySorted()),
            ],
            'report_basis' => [
                'array'
            ],
            'report_basis.*' => [
                IsInteger::make(isStrict: false),
                ModelExists::make(StructureLevel::class),
            ],
            'created_by_id' => [
                IsInteger::make(isStrict: false),
                ModelExists::make(User::class),
            ]
        ];
    }

    public function getParams(): ReportManualListParams
    {
        return $this->params;
    }

    protected function passedValidation(): void
    {
        $this->initParams();
    }

    private function initParams(): void
    {
        $values = $this->safe()->collect();

        $this->params = new ReportManualListParams(
            reportType: $values->get('report_type'),
            reportBasis: $values->get('report_basis'),
            createdById: $values->get('created_by_id'),
        );
    }
}
