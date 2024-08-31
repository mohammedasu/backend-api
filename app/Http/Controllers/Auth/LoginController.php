<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Login and generate token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $login_credentials=[
            'username'=>$request->username,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            //generate the token for the user
            $result['token'] = auth()->user()->createToken('PassportToken@mymedisage.com')->accessToken;
            $result['role'] = !empty(auth()->user()->roles->first()->name) ? auth()->user()->roles->first()->name : null;
            $result['permissions'] = [];
            if(!empty(auth()->user()->getAllPermissions())) {
                foreach (auth()->user()->getAllPermissions() as $key => $value) {
                    // $result['permissions'][$key]['id'] = $value->id;
                    $result['permissions'][$key] = $value->name;
                }
            }
            // $result['name'] = $result['permissions'][0]['name'];
            //now return this token on success login attempt
            return ApiResponse::successResponse(Constants::RESPONSE_SUCCESS_MESSAGE, $result);
        }
        return ApiResponse::failureResponse('Invalid Crediantail.',null, 401);
    }

    /**
     * Revoke access token
     */
    public function logout(): JsonResponse
    {
        if (auth('api')->user()->token()->revoke()) {
            return ApiResponse::successResponse('User logout successfully.');
        }
        return ApiResponse::failureResponse('Something went wrong.', '', 400);
    }

    /**
     * This function is used to verify the user token
     */
    public function verifyToken(): JsonResponse
    {
        if (auth('api')->check()) {
            return ApiResponse::successResponse('Token verified successfully.');
        }
        return ApiResponse::failureResponse('Token not verified or expired.', '', 400);
    }
}
