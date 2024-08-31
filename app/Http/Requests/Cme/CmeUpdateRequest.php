<?php

namespace App\Http\Requests\Cme;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CmeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type'                      => 'required',
            'name'                      => 'required|string|max:255|unique:cmes,name,' . $this->cme->id . ',id,deleted_at,NULL',
            'description'               => 'required',
            'landing_page_button_text'  => 'string|nullable',
            'heading_text'              => 'required|string',
            'survey_url'                => 'string|nullable',
            'passing_criteria'          => 'required|integer',
            'coins'                     => 'integer|nullable',
            'coins_type'                => 'string',
            'pass_text'                 => 'required|string',
            'pass_button_text'          => 'required|string',
            'fail_text'                 => 'string|nullable',
            'fail_button_text'          => 'string|nullable',
            'certificate_template_id'   => 'sometimes|nullable|exists:certificates,id',
            'registration_template_id'  => 'sometimes|nullable|exists:registration_templates,id',
            'time_in_seconds'           => 'integer', // 0 => in active, 1 => on module, 3 => on questions
            'questions'                 => 'required',
            'attachments'               => 'required',
            'landing_page_image'        => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'survey_background_mobile_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'pass_image'                => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'fail_image'                => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'survey_background_image'   => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'allowed_members_from'      => 'required|in:data_filter,csv,all',
            'members_csv_file'          => 'mimes:csv,txt|nullable|max:2048',
            'data_filter_id'            => 'required_if:allowed_members_from,data_filter|exists:data_filters,id',
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
