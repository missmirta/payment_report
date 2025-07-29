<?php

namespace PaymentReport\Services;

use PaymentReport\Models\PaymentReportDetails;
use Illuminate\Database\Eloquent\Collection;
use PaymentReport\Repositories\ReportRepository;

class ReportBuilder
{
    public function __construct(
        private readonly ReportRepository $paypointRepository,
    ) {
    }

    public function getPaymentData(
        PaymentReportDetails $details
    ): array {
        $dates = $details->getUnGeneratedReport()->getReportDates();
        $collection = $this->paypointRepository->getReportDataByReportType($details, $dates);

        return $this->transformCollection($collection);
    }

    private function transformCollection(Collection $collection): array
    {
        $result = $collection->groupBy('region_name')->map(function ($groupedByRegion) {
            return $groupedByRegion->groupBy('district_name')->map(function ($groupedByDistrict) {
                return $groupedByDistrict->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'location' => $item->location,
                        'address' => $item->address,
                        'email' => $item->email,
                        'phone_number' => $item->phone_number,
                        'payment_total' => $item->payment_total,
                        'created_at' => $item->created_at,
                        'cashiers_count' => $item->cashiers_count
                    ];
                });
            });
        });
        $result->put('paypoint_number', $collection->count());

        return $result->toArray();
    }
}
