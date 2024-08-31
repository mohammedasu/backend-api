<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CmeController, 
    CmeMapController, 
    QuestionBankMapController,
    QuestionBankController,    
};

Route::post('import-cme-questions', [QuestionBankMapController::class, 'importQuestions']);
Route::group(['prefix' => 'cme'], function () {
    Route::post('status', [CmeController::class, 'toggleStatus']);
});
Route::apiResource('cme', CmeController::class);
Route::apiResource('cme-maps', CmeMapController::class);
Route::apiResource('question-bank-maps', QuestionBankMapController::class);
Route::apiResource('question-banks', QuestionBankController::class);