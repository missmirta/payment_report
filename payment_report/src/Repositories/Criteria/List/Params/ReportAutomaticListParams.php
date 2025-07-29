<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List\Params;

class ReportAutomaticListParams
{
    public function __construct(
        public readonly ?array $reportType = [],
        public readonly ?array $reportBasis = []
    ) {
    }
}
