<?php

declare(strict_types=1);

namespace PaymentReport\Models\Enum;

use App\Models\Enums\EnumsToArray;

enum ReportBasisCode: string
{
    use EnumsToArray;

    case National = 'NT';
    case Regional = 'RG';
    case District = 'DS';
}
