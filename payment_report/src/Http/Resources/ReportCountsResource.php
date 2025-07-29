<?php

namespace PaymentReport\Http\Resources;

use BillingReport\Models\Counts\Type;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'ReportCountsResource',
    description: 'ReportCountsResource item resource',
    type: 'array',
    items: new OAA\Items(
        properties: [
            new OAA\Property(
                property: 'type',
                type: 'string',
                enum: [
                    Type::Manual,
                    Type::Automatic,
                    Type::Preset,
                ]
            ),
            new OAA\Property(property: 'count', type: 'number'),
        ]
    ),
    example: [
        ['type' => Type::Manual, 'count' => 0],
        ['type' => Type::Automatic, 'count' => 0],
        ['type' => Type::Preset, 'count' => 0],
    ]
)]
class ReportCountsResource extends JsonResource
{
}
