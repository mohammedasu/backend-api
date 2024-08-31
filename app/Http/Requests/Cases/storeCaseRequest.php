<?php

namespace App\Http\Requests\Cases;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class storeCaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        request()->merge(['question_data' => json_decode(request('question_data'), true)]);
        // request()->merge($data[0]);
        // request()->merge((array)json_decode(request('question_data'), true));
        //request('question_data')
        //Log::info(request('question_data'));

        // if(is_array(request('question_data'))){
        //     Log::info(request('question_data'));
        // }
        
        return [
            'title'                     => 'required',
            'description'               => 'required',
            'question_type'             => 'required',
            'community_selected'        => 'required',
            //'partner_division_id'       => 'required_if:expert_id,null',
            //'expert_id'                 => 'required_if:partner_division_id,null',
            //'question_data'              => 'required|array',
            //'question_data.*.question'  => 'required',
            //'question_data.*.type'      => 'required',
            'meta_desc'                 => 'nullable|max:240',
            'image'                     => 'mimes:png,jpg,jpeg|nullable|max:2048'
        ];

        // foreach (request('question_data') as $key => $value) {
        //     $value['question_data.*.question'] = 'required';
        //     $value['question_data.*.type']     = 'required';
        //     array_push($arr,$value);
        // }
        // Log::info($arr);
       // return $arr;
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
