<?php

declare(strict_types=1);

namespace PaymentReport\Models\Attributes\Concerns;

use Carbon\Carbon;

interface DateFromAttributeInterface
{
    public const ATTRIBUTE_DATE_FROM = 'date_from';
    public function getDateFrom(): Carbon;
    public function setDateFrom(Carbon $value): self;
}
