<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{QuestionController,QuestionReplyController,QuestionReferenceController};

Route::resource('question-references', QuestionReferenceController::class);
Route::resource('questions', QuestionController::class);
Route::resource('question-replies', QuestionReplyController::class);
