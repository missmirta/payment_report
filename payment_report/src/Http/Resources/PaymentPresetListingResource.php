<?php

namespace PaymentReport\Http\Resources;

use PaymentReport\Models\Enum\Frequency;
use PaymentReport\Models\PaymentReportDetails;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'PaymentPresetListingResource',
    description: 'Preset Listing Resource',
    properties: [
        new OAA\Property(property: 'id', type: 'string'),
        new OAA\Property(property: 'preset_name', type: 'string'),
        new OAA\Property(property: 'report_type', type: 'string'),
        new OAA\Property(property: 'frequency', type: 'array', items: new OAA\Items(type: 'string', enum: [
            Frequency::daily,
            Frequency::weekly,
            Frequency::monthly,
        ])),
        new OAA\Property(property: 'report_basis', ref: '#/components/schemas/PaymentReportBasisResource'),
    ]
)]
class PaymentPresetListingResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var PaymentReportDetails $reportPreset */
        $reportPreset = $this->resource;

        return [
            'id' => $reportPreset->getKey(),
            'preset_name' => $reportPreset->getName(),
            'report_type' => $reportPreset->getReportType(),
            'frequency' => $reportPreset->getFrequency()->getData(),
            'report_basis' => PaymentReportBasisResource::make($this->resource->getBasisStructureLevel()),
        ];
    }
}
