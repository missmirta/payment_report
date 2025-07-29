<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests\Counts;

use PaymentReport\Models\Counts\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportCountsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'types' => [
                'array',
                Rule::in(Type::toArray())
            ],
        ];
    }

    public function getTypes(): array
    {
        return $this->input('types', Type::toArray());
    }
}
