<?php

namespace PaymentReport\Http\Resources;

use PaymentReport\Models\Enum\ReportType;
use PaymentReport\Models\PaymentReport;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAA;

#[OAA\Schema(
    title: 'ReportAutomaticListingResource',
    description: 'Report Automatic Listing Resource',
    properties: [
        new OAA\Property(
            property: 'details',
            properties: [
                new OAA\Property(property: 'report_basis', ref: '#/components/schemas/PaymentReportBasisResource'),
                new OAA\Property(property: 'report_type', type: 'string', enum: [
                    ReportType::vendor, ReportType::customer
                ]),
                new OAA\Property(property: 'time_interval', ref: '#/components/schemas/GlobalCycleIntervalResource'),
            ],
            type: 'object'
        ),
        new OAA\Property(property: 'created_on', type: 'string', format: 'date-time'),
        new OAA\Property(property: 'file_id', type: 'string', format: 'uuid'),
    ]
)]
class ReportPaymentAutomaticListingResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var PaymentReport $report */
        $report = $this->resource;

        return [
            'id' => $report->getKey(),
            'name' => $report->getDetails()->getName(),
            'details' => [
                'report_basis' => PaymentReportBasisResource::make($report->getDetails()->getBasisStructureLevel()),
                'report_type' => $report->getDetails()->getReportType(),
                'time_interval' => $report->getReportDates(),
            ],
            'created_on' => $report->getAttribute('created_at'),
            'file_id' => $report->getFileId(),
        ];
    }
}
