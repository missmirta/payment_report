<?php

declare(strict_types=1);

namespace PaymentReport\Models\Enum;

use App\Models\Enums\EnumsToArray;

enum ReportType: string
{
    use EnumsToArray;

    case customer = 'customer';
    case vendor = 'vendor';
}
