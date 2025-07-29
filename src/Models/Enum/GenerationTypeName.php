<?php

declare(strict_types=1);

namespace PaymentReport\Models\Enum;

use App\Models\Enums\EnumsToArray;

enum GenerationTypeName: string
{
    use EnumsToArray;

    case manual = 'manual';
    case preset = 'preset';
}
