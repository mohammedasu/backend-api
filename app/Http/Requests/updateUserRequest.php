<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Constants\Constants;
use App\Helpers\ApiResponse;

class updateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:admin_login,username,'.$this->admin_user->id,
            'email' => 'required|email|unique:admin_login,email,'.$this->admin_user->id,
            'password' => 'nullable',
            'confirm_password' => 'nullable|same:password',
            'role' => 'required'
        ];
    }


    /**
     * Failed Validation response
     *
     * @param Validator $validator [description]
     *
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::validationFailure(
                Constants::RESPONSE_ERROR_MESSAGE,
                $validator->errors()
            )
        );
    }
}
