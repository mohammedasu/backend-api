<?php

namespace App\Http\Requests\QuestionBank;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionBankStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'question'      => 'required|unique:question_bank,question,NULL,id,deleted_at,NULL,question_type,'.$this->question_type,
            'question_type' => 'required',
            'correct_option'=> 'required_if:question_type,mcq',
            'options'       => 'required_if:question_type,mcq',
        ];
    }


    /**
     * Failed Validation response
     *
     * @param Validator $validator [description]
     *
     * @return object
     */
    public function failedValidation(Validator $validator): object
    {
        throw new HttpResponseException(
            ApiResponse::validationFailure(
                Constants::RESPONSE_ERROR_MESSAGE,
                $validator->errors()
            )
        );
    }
}