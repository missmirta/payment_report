<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List\Params;

class ReportManualListParams
{
    public function __construct(
        public readonly ?array $reportType = [],
        public readonly ?array $reportBasis = [],
        public readonly ?string $createdById = null
    ) {
    }
}
