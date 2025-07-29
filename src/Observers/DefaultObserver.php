<?php

declare(strict_types=1);

namespace PaymentReport\Observers;

use PaymentReport\Models\PaymentReportDetails;

class DefaultObserver
{
    public function __construct()
    {
    }

    public function creating(PaymentReportDetails $record): void
    {
        $record->setName($this->createName($record));
    }

    public function updating(PaymentReportDetails $record): void
    {
        if ($record->isDirty('report_basis')) {
            $record->setName($this->createName($record));
        }
    }

    private function createName(PaymentReportDetails $record): string
    {
        return $record->getBasisStructureLevel()->getAttribute('name');
    }
}
