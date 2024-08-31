<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\{MasterController};

Route::group(['prefix' => 'master'], function () {
    Route::get('fetch_forum_types', [MasterController::class, 'fetchForumTypes'])->name('fetch_forum_types');
    Route::get('fetch_user_types', [MasterController::class, 'fetchUserTypes'])->name('fetch_user_types');
    Route::get('fetch_country_list', [MasterController::class, 'CountryList'])->name('fetch_country_list');
    
    Route::get('fetch_state_by_country/{country}', [MasterController::class, 'getCountryState']);
    Route::get('fetch_city_by_state/{country}/{state}', [MasterController::class, 'getCityState']);

    Route::get('fetch_datafilter_member_types', [MasterController::class, 'getDataFilterMemberTypes'])->name('fetch_datafilter_member_types');
    Route::get('fetch_digimr_statuses', [MasterController::class, 'getDigiMrStatus'])->name('fetch_digimr_statuses');
    Route::get('fetch-question-bank-types', [MasterController::class, 'fetchQuestionBankTypes'])->name('fetch_question_bank_types');
    Route::get('fetch-attachment-types', [MasterController::class, 'fetchAttachmentTypes'])->name('fetch_attachment_types');
    Route::get('fetch-attachments', [MasterController::class,'fetchAttachments']);

    Route::get('fetch_state_by_countries/{countries}', [MasterController::class, 'getStateBasedOnMultipleCountry']);
    
    Route::get('fetch_city_by_states/{states}', [MasterController::class, 'getCityBasedOnMultipleState']);

    Route::get('fetch_all_states', [MasterController::class, 'fetchAllStates']);
    Route::get('fetch_all_cities', [MasterController::class, 'fetchAllCities']);

   
});
