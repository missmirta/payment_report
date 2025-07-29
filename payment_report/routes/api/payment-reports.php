<?php

use App\Models\Contracts\PermissionInterface;
use Authorization\Models\PersonalAccessToken\Enums\TokenAbility;
use Core\Authorization\Helpers\AuthApiRoutesMiddlewaresHelper;
use Illuminate\Support\Facades\Route;
use PaymentReport\Http\Controllers\Api\DeleteController;
use PaymentReport\Http\Controllers\Api\DownloadController;
use PaymentReport\Http\Controllers\Api\ReportController;
use PaymentReport\Http\Controllers\Api\ReportListController;

// Prefix [/api/v1/payment-reports]

// Protected routes
Route::group(['middleware' => AuthApiRoutesMiddlewaresHelper::getMiddlewares([TokenAbility::ACCESS_API])], function () {
    Route::post('preset', [ReportController::class, 'createPreset'])
        ->can(PermissionInterface::PAYMENT_REPORT_PRESET_MANAGE);
    Route::post('manual', [ReportController::class, 'createManual'])
        ->can(PermissionInterface::PAYMENT_REPORT_MANUAL_CREATE);

    Route::get('automatic', [ReportListController::class, 'automaticList'])
        ->can(PermissionInterface::PAYMENT_REPORT_AUTOMATIC_LIST);
    Route::get('manual', [ReportListController::class, 'manualList'])
        ->can(PermissionInterface::PAYMENT_REPORT_MANUAL_LIST);
    Route::get('preset', [ReportListController::class, 'presetList'])
        ->can(PermissionInterface::PAYMENT_REPORT_PRESET_LIST);

    Route::get('get-basis', [ReportController::class, 'getReportBasisByStructureLevel']);

    Route::get('{paymentReport}/download', [DownloadController::class, 'download'])
        ->middleware('permission:' . implode('|', [
                PermissionInterface::PAYMENT_REPORT_AUTOMATIC_DOWNLOAD,
                PermissionInterface::PAYMENT_REPORT_MANUAL_DOWNLOAD,
            ]));
    Route::get('download', [DownloadController::class, 'bulkDownload'])
        ->middleware('permission:' . implode('|', [
                PermissionInterface::PAYMENT_REPORT_AUTOMATIC_DOWNLOAD,
                PermissionInterface::PAYMENT_REPORT_MANUAL_DOWNLOAD,
            ]));

    Route::put('{paymentReportPreset}/preset', [ReportController::class, 'updatePreset'])
        ->can(PermissionInterface::PAYMENT_REPORT_PRESET_MANAGE);
    Route::get('{paymentReportPreset}/preset', [ReportController::class, 'getPreset']);

    Route::delete('preset', [DeleteController::class, 'deletePreset'])
        ->can(PermissionInterface::PAYMENT_REPORT_PRESET_MANAGE);
    Route::delete('', [DeleteController::class, 'deleteReport'])
        ->can(PermissionInterface::PAYMENT_REPORT_MANUAL_DELETE);

    Route::get('counts', [ReportListController::class, 'counts']);
});
