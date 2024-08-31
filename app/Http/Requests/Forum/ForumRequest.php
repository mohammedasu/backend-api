<?php

namespace App\Http\Requests\Forum;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForumRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        return [
            'name'                => 'required|string|max:255',
            'link_name'               => 'required|unique:partner_divisions',
            "forum_visibility" => "required",
            "forum_type" => "required",
            'partner_id' => 'required_if:forum_type,==,partner|nullable',
            "geographic_type" => "required",
            'country' => 'required',
            'state' => 'required_if:geographic_type,==,state|nullable',
            'city' => 'required_if:geographic_type,==,city|nullable',
            'privacy_rule' => 'required_if:forum_visibility,==,private|nullable',
            "image_name" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "website_banner_image" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "pre_login_image" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "pre_login_image2" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "thumbnail_image" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "thumbnail_image_logo" => "mimes:jpeg,png,jpg,gif,svg|max:2048|nullable"


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
