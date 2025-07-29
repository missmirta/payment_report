<?php

declare(strict_types=1);

namespace PaymentReport\Plugins\FilePresets;

use FilesystemExtended\Plugins\FilePresets\FilePresetBase;

class PaymentReportArchive extends FilePresetBase
{
    public const NAME = 'report-payment-archive';

    public function getSaveFolder(): string
    {
        return 'report-payment-archive';
    }
}
