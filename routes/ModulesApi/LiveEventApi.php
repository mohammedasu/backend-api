<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LiveEventController;
Route::get('live-event/get-quiz', [LiveEventController::class, 'getQuiz']);
Route::apiResource('live-event', LiveEventController::class);
Route::group(['prefix' => 'live-event'], function () {
    Route::post('status', [LiveEventController::class, 'updateStatus']);
    Route::get('generate-certificate/{id}', [LiveEventController::class, 'generateCertificate']);
    Route::get('live-event-download/{id}', [LiveEventController::class, 'liveEventDownload']);
    Route::get('send-mail/{id}', [LiveEventController::class, 'sendMail']);
    
});