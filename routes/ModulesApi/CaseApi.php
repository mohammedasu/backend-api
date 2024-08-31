<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CaseController,CaseItemController};

Route::group(['prefix' => 'cases'], function () {
    Route::post('download-zip/{id}', [CaseController::class, 'download']);
    Route::post('status', [CaseController::class, 'toggleStatus']);
    Route::post('comment-status', [CaseController::class, 'commentStatus']);
    Route::delete('delete-case-question/{id}', [CaseController::class, 'destroyCaseQuestion']);
});
Route::apiResource('cases', CaseController::class)->except(['create', 'edit']);

Route::delete('case-item-delete/{id}', [CaseItemController::class, 'destroyCaseImage']);
