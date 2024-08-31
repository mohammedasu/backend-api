<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Requests\ResetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a passport in built function to reset the password.
    |
    */

    /**
     * Reset the given user's password.
     *
     * @param ResetRequest $request
     * @return JsonResponse
     */
    public function reset(ResetRequest $request)
    {
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                // ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        //If the password was successfully reset, we will redirect the user back to the application's home authenticated view. If there is an error we can redirect them back to where they came from with their error message.

        // This $status will matches with PASSWORD_RESET constant defines in password facades. if matched then give success msg else error.

        return $status === Password::PASSWORD_RESET
                ? ApiResponse::successResponse(trans($status))
            : ApiResponse::failureResponse(trans($status));

    }
}
