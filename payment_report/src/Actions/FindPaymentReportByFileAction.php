<?php

declare(strict_types=1);

namespace PaymentReport\Actions;

use PaymentReport\Actions\Contracts\FindPaymentReportByFileActionInterface;
use PaymentReport\Models\Contracts\PaymentReportInterface;
use PaymentReport\Repositories\Contracts\ReportRepositoryInterface;
use App\Repositories\Common\Criteria\LimitQueryCriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Repositories\Criteria\FileQueryCriteria;

final class FindPaymentReportByFileAction implements FindPaymentReportByFileActionInterface
{
    public function __construct(private readonly ReportRepositoryInterface $repository)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(string $fileId): PaymentReportInterface
    {
        $result = $this->repository->makeQuery([
            FileQueryCriteria::make($fileId),
            LimitQueryCriteria::make(1),
        ])->first();

        if (!$result instanceof PaymentReportInterface) {
            throw (new ModelNotFoundException())->setModel(PaymentReport::class);
        }

        return $result;
    }
}
