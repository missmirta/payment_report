<?php

namespace PaymentReport\Models\Counts;

use App\Models\Enums\EnumsToArray;
use PaymentReport\Models\Attributes\Concerns\GenerationTypeAttributeInterface;
use PaymentReport\Models\PaymentReport;
use PaymentReport\Models\PaymentReportDetails;
use PaymentReport\Models\Relation\Contracts\HasDetailsRelationInterface;
use PaymentReport\Models\Enum\GenerationTypeName;
use Illuminate\Database\Eloquent\Builder;

use function with;

enum Type: string
{
    use EnumsToArray;

    case Manual = 'manual';
    case Automatic = 'automatic';
    case Preset = 'preset';

    public static function initReportQuery(array $type): Builder
    {
        return PaymentReport::query()
            ->whereHas(HasDetailsRelationInterface::RELATION_DETAILS, function ($query) use ($type) {
                $query->where(GenerationTypeAttributeInterface::ATTRIBUTE_GENERATION_TYPE, $type);
            });
    }

    public static function initPresetQuery(array $type): Builder
    {
        return PaymentReportDetails::query();
    }

    public function getQuery(): Builder
    {
        return match ($this) {
            self::Manual => with([GenerationTypeName::manual], [$this, 'initReportQuery']),
            self::Automatic => with([GenerationTypeName::preset], [$this, 'initReportQuery']),
            self::Preset => with([GenerationTypeName::preset], [$this, 'initPresetQuery']),
        };
    }

    public function modelCount(): int
    {
        return $this->getQuery()->count();
    }
}
