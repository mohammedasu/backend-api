<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;


class ChangePasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Change Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling change password requests.
    |
    */

    /**
     * change the given user's password.
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $userPassword = $user->password;

        if (!Hash::check($request->current_password, $userPassword)) {
            return ApiResponse::failureResponse('Password miss matched.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return ApiResponse::successResponse('Password changed successfully.');
    }
}
