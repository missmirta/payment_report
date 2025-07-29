<?php

declare(strict_types=1);

namespace PaymentReport\Models\Enum;

use App\Models\Enums\EnumsToArray;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

enum Frequency: string
{
    use EnumsToArray;

    case daily = 'daily';
    case weekly = 'weekly';
    case monthly = 'monthly';

    public function getDateInterval(): CarbonPeriod
    {
        return match ($this) {
            self::daily => CarbonPeriod::create(Carbon::now()->subDay(), Carbon::now()),
            self::weekly => CarbonPeriod::create(Carbon::now()->subWeek(), Carbon::now()),
            self::monthly => CarbonPeriod::create(Carbon::now()->subMonth(), Carbon::now()),
        };
    }
}
