<?php

namespace App\Http\Resources\NotificationMaster;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationMasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                                => $this->id,
            'notification_master_ref_no'        => $this->notification_master_ref_no,
            'event_name'                        => $this->event_name,
            'email_template_ref_no'             => $this->email_template_ref_no,
            'sms_template_ref_no'               => $this->sms_template_ref_no,
            'push_notification_template_ref_no' => $this->push_notification_template_ref_no,
            'page_notification_template_ref_no' => $this->page_notification_template_ref_no,
            'email_template_name'               => !empty($this->email_template_name) ? $this->email_template_name->name : null,
            'sms_template_name'                 => !empty($this->sms_template_name) ? $this->sms_template_name->name : null,
            'push_template_name'                => !empty($this->push_template_name) ? $this->push_template_name->name : null,
            'page_template_name'                => !empty($this->page_template_name) ? $this->page_template_name->name : null,
            'is_active'                         => $this->is_active
        ];
    }
}
