<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

   // use SendsPasswordResetEmails;

    public function sendResetLinkEmail(ForgotRequest $request)
    {

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // constant saved in passport constant file.
       
        $response = $this->broker('admin')->sendResetLink($request->only('email'));
        
        return $response == Password::RESET_LINK_SENT
            ? ApiResponse::successResponse(trans($response))
            : ApiResponse::failureResponse(trans($response));
    }

}
