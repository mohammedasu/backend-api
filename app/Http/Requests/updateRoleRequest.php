<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Constants\Constants;
use App\Helpers\ApiResponse;

class updateRoleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'permission' => 'required',
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
