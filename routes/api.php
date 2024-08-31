<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [LoginController::class, 'login'])->name('login');

// master api for api like country list and so on without login
require('MasterApi/MasterApi.php');

Route::post('forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::get('verify-token', [LoginController::class, 'verifyToken']);

Route::middleware('auth:api')->group(function () {
    require('ModulesApi/CaseApi.php');
    require('ModulesApi/CmeApi.php');
    require('ModulesApi/LiveEventApi.php');
    require('ModulesApi/QuestionApi.php');
    require('ModulesApi/NotificationApi.php');
    require('ModulesApi/NotificationMasterApi.php');


    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
