<?php

declare(strict_types=1);

namespace PaymentReport\Http\Resources;

use App\Http\Resources\Users\UserRoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'PaymentReportInformationResource',
    properties: [
        new OAA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OAA\Property(property: 'details', ref: '#/components/schemas/PaymentPresetInformationResource'),
        new OAA\Property(property: 'created_by_id', ref: 'api-docs.json#/components/schemas/UserShortResource'),
        new OAA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OAA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
class PaymentReportInformationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'details' => PaymentPresetInformationResource::make($this->resource->getDetails()),
            'created_by_id' => UserRoleResource::make($this->resource->getCreatedBy()),
            'created_at' => $this->resource->getAttributeValue('created_at'),
            'updated_at' => $this->resource->getAttributeValue('updated_at'),
        ];
    }
}
