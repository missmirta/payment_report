<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use PaymentReport\Models\PaymentReportDetails;
use App\Rules\ModelExists;
use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class DeletePresetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'preset' => ['required', 'array'],
            'preset.*' => ['string', 'uuid', ModelExists::make(
                PaymentReportDetails::class,
                'id',
                function (Builder $query) {
                    $query->where(
                        GenerationTypeAttributeInterface::ATTRIBUTE_GENERATION_TYPE,
                        GenerationTypeName::preset
                    );
                }
            )],
        ];
    }

    public function getPresetsIds(): array
    {
        return $this->input('preset');
    }
}
