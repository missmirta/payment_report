<?php

declare(strict_types=1);

namespace PaymentReport\Repositories\Criteria\List\Params;

class ReportPresetListParams
{
    public function __construct(
        public readonly ?string $search = null
    ) {
    }
}
