<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use App\Http\Requests\Common\PaginatableParams;
use App\Http\Requests\Common\PaginatableRequestParamsTrait;
use App\Http\Requests\Common\SearchableRequestParamsTrait;
use App\Http\Requests\Common\SortableParams;
use App\Http\Requests\Common\SortableRequestParamsTrait;
use Illuminate\Foundation\Http\FormRequest;
use PaymentReport\Repositories\Criteria\List\Params\ReportPresetListParams;

class ReportPresetListRequest extends FormRequest implements SortableParams, PaginatableParams
{
    use PaginatableRequestParamsTrait;
    use SortableRequestParamsTrait;
    use SearchableRequestParamsTrait;

    private ReportPresetListParams $params;
    public function rules(): array
    {
        return [
            'search' => ['string'],
        ];
    }

    public function getParams(): ReportPresetListParams
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

        $this->params = new ReportPresetListParams(
            search: $values->get('search')
        );
    }
}
