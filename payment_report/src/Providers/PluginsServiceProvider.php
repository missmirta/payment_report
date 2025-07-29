<?php

declare(strict_types=1);

namespace PaymentReport\Providers;

use App\Models\Contracts\PermissionInterface;
use FilePresetAccessCheckerPermissions\Plugins\FilePresets\AccessCheckers\PermissionsAccessChecker;
use FilesystemExtended\Plugins\FilePresets\AccessCheckers\Enums\Action;
use FilesystemExtended\Plugins\FilePresets\AccessCheckers\FilePresetAccessCheckerDefinition;
use FilesystemExtended\Plugins\FilePresets\AccessCheckers\FilePresetAccessCheckerDefinitions;
use FilesystemExtended\Plugins\FilePresets\FilePresetFactory;
use Illuminate\Support\ServiceProvider;
use PaymentReport\Plugins\FilePresets as Presets;
use PaymentReport\Plugins\FilePresets\AccessCheckers\ReportPaymentPdf\View\ViewOwnAccessChecker;

class PluginsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFilePresets();
    }

    public function registerFilePresets(): void
    {
        $this->app->tag(Presets\ReportPayment::class, FilePresetFactory::TAG);
        $this->app->tag(Presets\PaymentReportArchive::class, FilePresetFactory::TAG);

        $this->registerFilePresetAccessCheckers();
    }

    private function registerFilePresetAccessCheckers(): void
    {
        FilePresetAccessCheckerDefinitions::add(
            presetName: Presets\ReportPayment::NAME,
            accessCheckerDefinitions: [
                FilePresetAccessCheckerDefinition::make(
                    action: Action::VIEW,
                    class: PermissionsAccessChecker::class,
                    parameters: [
                        PermissionsAccessChecker::PARAM_PERMISSIONS => [
                            PermissionInterface::PAYMENT_REPORT_MANUAL_DOWNLOAD,
                            PermissionInterface::PAYMENT_REPORT_AUTOMATIC_DOWNLOAD,
                        ],
                    ],
                ),
                FilePresetAccessCheckerDefinition::make(
                    action: Action::VIEW,
                    class: ViewOwnAccessChecker::class,
                ),
            ],
        );

        FilePresetAccessCheckerDefinitions::add(
            presetName: Presets\PaymentReportArchive::NAME,
            accessCheckerDefinitions: [
                FilePresetAccessCheckerDefinition::make(
                    action: Action::VIEW,
                    class: PermissionsAccessChecker::class,
                    parameters: [
                        PermissionsAccessChecker::PARAM_PERMISSIONS => [
                            PermissionInterface::PAYMENT_REPORT_MANUAL_DOWNLOAD,
                            PermissionInterface::PAYMENT_REPORT_AUTOMATIC_DOWNLOAD,
                        ],
                    ],
                ),
            ],
        );
    }
}
