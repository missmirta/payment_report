<?php

declare(strict_types=1);

namespace PaymentReport\Http\Resources;

use App\Http\Resources\Users\UserClusterResource;
use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Models\PaymentReportDetails;
use Billing\Http\Resources\Tariffs\ServiceCategory\ServiceCategoryShortResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;
use Payment\Http\Resources\PaymentSources\Paypoint\PaypointShortResource;
use Payment\Http\Resources\PaymentSources\Vendor\VendorShortReportResource;

#[OAA\Schema(
    title: 'PaymentPresetInformationResource',
    properties: [
        new OAA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OAA\Property(property: 'name', type: 'string'),
        new OAA\Property(property: 'report_basis', ref: '#/components/schemas/PaymentReportBasisResource'),
        new OAA\Property(property: 'report_type', type: 'string', format: 'string'),
        new OAA\Property(property: 'frequency', type: 'array', items: new OAA\Items(
            type: 'string',
            enum: [
                Frequency::daily,
                Frequency::weekly,
                Frequency::monthly
            ],
            example: Frequency::daily
        )),
        new OAA\Property(
            property: 'vendors',
            ref: 'api-payment-docs.json#/components/schemas/VendorShortReportResource'
        ),
        new OAA\Property(property: 'paypoints', ref: 'api-payment-docs.json#/components/schemas/PaypointShortResource'),
        new OAA\Property(
            property: 'service_categories',
            ref: 'api-billing-docs.json#/components/schemas/ServiceCategoryShortResource'
        ),
        new OAA\Property(
            property: 'payment_methods',
            type: 'array',
            items: new OAA\Items(type: 'string', example: 'cash')
        ),
        new OAA\Property(property: 'regions', type: 'array', items: new OAA\Items(type: 'number')),
        new OAA\Property(property: 'districts', type: 'array', items: new OAA\Items(type: 'number')),
        new OAA\Property(property: 'created_by_id', ref: 'api-docs.json#/components/schemas/UserClusterResource'),
        new OAA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OAA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
/**
 * @property PaymentReportDetails $resource
 */
class PaymentPresetInformationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->getName(),
            'report_basis' => PaymentReportBasisResource::make($this->resource->getBasisStructureLevel()),
            'report_type' => $this->resource->getReportType(),
            'frequency' => $this->resource->getFrequency()?->getData(),
            'vendors' => VendorShortReportResource::collection(
                $this->resource->getVendors()
            ),
            'paypoints' => PaypointShortResource::collection(
                $this->resource->getPaypoints()
            ),
            'service_categories' => ServiceCategoryShortResource::collection(
                $this->resource->getServiceCategories()
            ),
            'payment_methods' => $this->resource->getCriteria()->getPaymentMethods(),
            'regions' => $this->resource->getCriteria()->getRegions(),
            'districts' => $this->resource->getCriteria()->getDistricts(),
            'created_by_id' => UserClusterResource::make($this->resource->getCreatedBy()),
            'created_at' => $this->resource->getAttributeValue('created_at'),
            'updated_at' => $this->resource->getAttributeValue('updated_at'),
        ];
    }
}
