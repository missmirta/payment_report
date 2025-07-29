<?php

declare(strict_types=1);

namespace PaymentReport\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'PaymentReportBasisResource',
    properties: [
        new OAA\Property(property: 'id', type: 'int64'),
        new OAA\Property(property: 'code', type: 'string'),
        new OAA\Property(property: 'name', type: 'string'),
    ]
)]
class PaymentReportBasisResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'code' => $this->resource->getAttribute('code'),
            'name' => $this->resource->getAttribute('name'),
        ];
    }
}
