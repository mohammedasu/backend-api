<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::post('notification/check-content', [NotificationController::class, 'checkContent']);
Route::get('notification/send-schedule', [NotificationController::class, 'sendSchedule']);
Route::get('notification/send-schedule-notification', [NotificationController::class, 'scheduleNotification']);
Route::get('notification/send-queued-notification', [NotificationController::class, 'sendQueueddNotification']);
Route::apiResource('notification', NotificationController::class);