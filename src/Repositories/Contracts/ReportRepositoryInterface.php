<?php

namespace PaymentReport\Repositories\Contracts;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface ReportRepositoryInterface extends BaseRepositoryInterface
{
    public function createReport(array $dates, ?int $userId = null): Model;
}
