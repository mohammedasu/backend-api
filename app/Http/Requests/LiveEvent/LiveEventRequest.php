<?php

namespace App\Http\Requests\LiveEvent;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LiveEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'link_id' => 'required|string|max:255|unique:live_events',
            "session_time" => "required",
            "buffer_time" => "required",
            "title" => "required",
            "partner_id" => "required|exists:partners,id",
            "video_id" => "required",
            // "amount" => "required_if:is_payed_event,1|numeric",
            // "currency" => "required_if:is_payed_event,1|string",
            "content_type" => "required_if:is_payed_event,1|string",
            "vchat_id" => "required",
            "live_event_text" => "required",
            'meta_description' => 'nullable|max:400',
            'banner_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'mobile_banner_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'register_image1' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'register_image2' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'thumbnail_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'register_success_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
            'event_completed_image' => 'mimes:png,jpg,jpeg|nullable|max:2048',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'community_selected.array' => 'The Community Selected must be an array',
    //     ];
    // }
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
