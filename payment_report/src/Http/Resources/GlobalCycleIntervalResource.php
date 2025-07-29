<?php

declare(strict_types=1);

namespace PaymentReport\Http\Resources;

use App\Http\Resources\GlobalCycle\GlobalCycleItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'GlobalCycleIntervalResource',
    properties: [
        new OAA\Property(property: 'from', ref: 'api-docs.json#/components/schemas/GlobalCycleItemResource'),
        new OAA\Property(property: 'to', ref: 'api-docs.json#/components/schemas/GlobalCycleItemResource'),
    ]
)]
class GlobalCycleIntervalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'from' => GlobalCycleItemResource::make($this->resource->getGlobalCycleEntityFrom()),
            'to' => GlobalCycleItemResource::make($this->resource->getGlobalCycleEntityTo())
        ];
    }
}
