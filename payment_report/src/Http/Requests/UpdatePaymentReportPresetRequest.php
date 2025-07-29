<?php

declare(strict_types=1);

namespace PaymentReport\Http\Requests;

use PaymentReport\Models\DTO\CriteriaData;
use PaymentReport\Models\DTO\FrequencyData;
use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Models\Enum\ReportType;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAA;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;
use PaymentReport\Http\Requests\Params\UpdatePresetParams;

#[Schema(
    title: 'UpdatePaymentReportPresetRequest',
    required: [
        'report_basis',
        'report_type',
        'frequency',
    ],
    properties: [
        new Property(
            property: 'report_basis',
            description: 'Base of report from route /reports/get-basis',
            type: 'integer'
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
    ]
)]
class UpdatePaymentReportPresetRequest extends BaseReportRequest
{
    public function rules(): array
    {
        return parent::rules() + [
                'frequency' => ['required', 'array'],
                'frequency.*' => ['required', 'string', Rule::in(Frequency::toArraySorted())],
            ];
    }

    public function getParams(): UpdatePresetParams
    {
        $data = $this->safe()->collect();

        return UpdatePresetParams::make(
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
    }
}
