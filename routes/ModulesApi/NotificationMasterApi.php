<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{NotificationMasterController};

Route::apiResource('notification-masters', NotificationMasterController::class);
Route::group(['prefix' => 'notification-masters'], function () {
    Route::post('status', [NotificationMasterController::class, 'toggleStatus']);
    Route::post('restore/{id}', [NotificationMasterController::class, 'restore']);
});
