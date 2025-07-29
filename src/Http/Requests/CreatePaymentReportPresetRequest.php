<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use App\Http\Requests\Common\ReverseFieldsRequestInterface;
use App\Http\Requests\Common\ReverseFieldsRequestTrait;
use PaymentReport\Models\DTO\CriteriaData;
use PaymentReport\Models\DTO\FrequencyData;
use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Models\Enum\ReportType;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAA;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use PaymentReport\Http\Requests\Params\CreatePresetParams;

#[Schema(
    title: 'CreatePaymentReportPresetRequest',
    required: [
        'report_basis',
        'report_type',
        'frequency',
    ],
    properties: [
        new Property(
            property: 'report_basis',
            description: 'Base of report from route /reports/get-basis',
            type: 'integer',
            format: 'int32'
        ),
        new Property(
            property: 'report_type',
            description: 'Base of report from route /reports/get-basis',
            type: 'string',
            enum: [
                ReportType::vendor,
                ReportType::customer
            ]
        ),
        new Property(property: 'frequency', type: 'array', items: new OAA\Items(type: 'string', enum: [
            Frequency::daily,
            Frequency::weekly,
            Frequency::monthly
        ])),
        new Property(property: 'region_id', type: 'array', items: new OAA\Items(type: 'integer', format: 'int32')),
        new Property(property: 'district_id', type: 'array', items: new OAA\Items(type: 'integer', format: 'int32')),
        new Property(
            property: 'service_category_uuid',
            type: 'array',
            items: new OAA\Items(type: 'string', format: 'uuid')
        ),
        new Property(
            property: 'paypoint',
            type: 'array',
            items: new OAA\Items(type: 'integer', format: 'int32')
        ),
        new Property(
            property: 'vendor',
            type: 'array',
            items: new OAA\Items(type: 'string', format: 'uuid')
        ),
        new Property(
            property: 'payment_method',
            type: 'array',
            items: new OAA\Items(type: 'string', example: 'cash')
        ),
        new Property(
            property: 'reverse_fields[]',
            type: 'array',
            items: new OAA\Items(type: 'string'),
            enum: self::ALLOWED_REVERSE_FIELDS
        ),
    ]
)]
class CreatePaymentReportPresetRequest extends BaseReportRequest implements ReverseFieldsRequestInterface
{
    use ReverseFieldsRequestTrait;

    public const ALLOWED_REVERSE_FIELDS = ['region_id', 'district_id'];

    public function rules(): array
    {
        return parent::rules() + [
                'frequency' => ['required', 'array'],
                'frequency.*' => ['required', 'string', Rule::in(Frequency::toArraySorted())],
            ] + $this->reverseFieldsRules();
    }

    public function messages(): array
    {
        return $this->reverseFieldsMessages();
    }

    public function getParams(): CreatePresetParams
    {
        $data = $this->safe()->collect();

        $params = CreatePresetParams::make(
            reportBasis: $data->get('report_basis'),
            reportType: ReportType::tryFrom($data->get('report_type')),
            createdById: $this->user()->getKey(),
            criteriaData: new CriteriaData(
                regions: $data->get('region_id', []),
                districts: $data->get('district_id', []),
                vendors: $data->get('vendor', []),
                serviceCategories: $data->get('service_category_uuid', []),
                paypoints: $data->get('paypoint', []),
                paymentMethods: $data->get('payment_method', []),
            ),
            frequencyData: new FrequencyData($data->get('frequency'))
        );

        $params->setReverseFields($this->getReverseFields());

        return $params;
    }
}
