<?php

namespace App\Http\Requests\Notification;

use App\Constants\Constants;
use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'engagement_name'   => 'required|unique:engagements,engagement_name,NULL,id,deleted_at,NULL',
            'notification_type' => 'required',
            'send_to_medium'    => 'required|in:test,csv,data_filter,none',
            'action_type'       => 'required|in:video,case,newsletter,newsarticle,live_event,custom',
            'device_type'       => 'required_if:notification_type,app_notification',
            'notification_title' => 'required_if:notification_type,app_notification',
            'notification_description' => 'required_if:notification_type,app_notification',
            'content'           => 'required_if:action_type,custom',
            'mobile_numbers'    => 'required_if:send_to_medium,test',
            'data_filter_id'    => 'required_if:send_to_medium,data_filter',
            'csv_file'          => 'required_if:send_to_medium,csv|mimes:csv,txt|max:3072|nullable',
            'image'             => 'sometimes|nullable|mimes:png,jpg,jpeg|max:2048',
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
