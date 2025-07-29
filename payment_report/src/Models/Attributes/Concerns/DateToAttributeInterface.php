<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use Carbon\Carbon;

interface DateToAttributeInterface
{
    public const ATTRIBUTE_DATE_TO = 'date_to';
    public function getDateTo(): Carbon;
    public function setDateTo(Carbon $value): self;
}
