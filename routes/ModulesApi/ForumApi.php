<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ForumController};

Route::apiResource('forums', ForumController::class);

Route::group(['prefix' => 'forums'], function () {
    Route::post('update-status/{id}', [ForumController::class, 'updateStatus']);
    Route::post('restore/{id}', [ForumController::class, 'Restore']);

});
