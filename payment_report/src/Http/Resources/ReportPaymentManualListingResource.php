<?php

namespace PaymentReport\Http\Resources;

use App\Http\Resources\Users\UserShortResource;
use PaymentReport\Models\PaymentReport;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'ReportManualListingResource',
    description: 'Report Manual Listing Resource',
    properties: [
        new OAA\Property(property: 'created_by_id', ref: 'api-docs.json#/components/schemas/UserShortResource'),
    ]
)]
class ReportPaymentManualListingResource extends ReportPaymentAutomaticListingResource
{
    public function toArray($request): array
    {
        /** @var PaymentReport $report */
        $report = $this->resource;

        return parent::toArray($this->resource) + [
            'created_by_id' => UserShortResource::make($report->getCreatedBy()),
        ];
    }
}
