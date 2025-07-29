<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use PaymentReport\Models\PaymentReport;
use App\Rules\ModelExists;
use Illuminate\Foundation\Http\FormRequest;

class DeleteReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'report' => ['required', 'array'],
            'report.*' => ['string', 'uuid', ModelExists::make(PaymentReport::class)],
        ];
    }

    public function getReportIds(): array
    {
        return $this->input('report');
    }
}
