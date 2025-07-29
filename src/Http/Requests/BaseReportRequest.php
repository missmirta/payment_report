<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use App\Models\District;
use App\Models\Region;
use App\Rules\Decorated\IsInteger;
use PaymentReport\Models\Attributes\Concerns\BasisAttributeInterface;
use PaymentReport\Models\Enum\ReportType;
use App\Models\StructureLevel;
use App\Rules\ModelExists;
use App\Rules\PresentIf;
use App\Rules\ProhibitedIf;
use App\Rules\Report\DistrictCheckByRegion;
use Billing\Models\Tariffs\ServiceCategory\ServiceCategory;
use PaymentReport\Models\Enum\ReportBasisCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Payment\Models\Payment\TransactionData\Enums\MethodsEnum;
use Payment\Models\PaymentSources\Paypoint\Paypoint;
use Payment\Models\PaymentSources\Vendor\Vendor;

abstract class BaseReportRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var StructureLevel $structureType */
        $structureType = StructureLevel::find($this->input(
            BasisAttributeInterface::ATTRIBUTE_REPORT_BASIS
        ));

        return [
            'report_basis' => ['required', IsInteger::make(), ModelExists::make(StructureLevel::class)],
            'report_type' => ['required', 'string', Rule::in(ReportType::toArraySorted())],
            'region_id' => ['array',
                new PresentIf($structureType->getCode() !== ReportBasisCode::National->value),
            ],
            'region_id.*' => [IsInteger::make(), Rule::exists(Region::class, 'id')],
            'district_id' => ['array'],
            'district_id.*' => [IsInteger::make(),
                Rule::exists(District::class, 'id'),
                new DistrictCheckByRegion($this->input('region_id', []))
            ],
            'service_category_uuid' => ['array',
                new PresentIf($this->input('report_type') === ReportType::customer->value),
                new ProhibitedIf($this->input('report_type') === ReportType::vendor->value),
            ],
            'service_category_uuid.*' => ['string',
                ModelExists::make(ServiceCategory::class, 'entity_uuid')],
            'paypoint' => ['array',
                new PresentIf($this->input('report_type') == ReportType::customer->value),
                new ProhibitedIf($this->input('report_type') == ReportType::vendor->value)
            ],
            'paypoint.*' => [IsInteger::make(), ModelExists::make(Paypoint::class, 'id')],
            'vendor' => ['array',
                new PresentIf($this->input('report_type') == ReportType::vendor->value),
                new ProhibitedIf($this->input('report_type') == ReportType::customer->value),
            ],
            'vendor.*' => ['string', ModelExists::make(Vendor::class, 'entity_uuid')],
            'payment_method' => ['array', 'present'],
            'payment_method.*' => ['string', Rule::in(MethodsEnum::toArraySorted())],
        ];
    }
}
