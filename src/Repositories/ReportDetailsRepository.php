<?php

namespace PaymentReport\Repositories;

use PaymentReport\Models\PaymentReportDetails;
use App\Repositories\BaseDBRepository;
use PaymentReport\Repositories\Contracts\ReportDetailsRepositoryInterface;

class ReportDetailsRepository extends BaseDBRepository implements ReportDetailsRepositoryInterface
{
    public function __construct(private readonly PaymentReportDetails $model)
    {
    }

    protected function getModel(): PaymentReportDetails
    {
        return $this->model;
    }
}
