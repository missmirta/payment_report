<?php

declare(strict_types=1);

namespace PaymentReport\Plugins\FilePresets;

use FilesystemExtended\Plugins\FilePresets\FilePresetBase;

class ReportPayment extends FilePresetBase
{
    public const NAME = 'report-payment-pdf';

    public function getSaveFolder(): string
    {
        return 'report-payment-pdf';
    }
}
