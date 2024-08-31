<?php

namespace App\Http\Resources\LiveEvent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveEventResource extends JsonResource
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
            'id'      => $this->id,
            'title'   => $this->title,
            'link_id' => $this->link_id,
            'session_time' => $this->session_time,
            'buffer_time' => $this->buffer_time,
            'partner_id' => $this->partner_id,
            'email_link' => $this->email_link,
            'time_zone' => $this->time_zone,
            'time_zone_code' => $this->time_zone_code,
            'calender_description' => $this->calender_description,
            'video_id' => $this->video_id,
            'vchat_id' => $this->vchat_id,
            'chat_type' => $this->chat_type,
            'live_event_text' => $this->live_event_text,
            'description' => $this->description,
            'tnc_detail' => $this->tnc_detail,
            'partner_division_id' => $this->partner_division_id,
            'community_id' => $this->community_id,
            'knowledge_category_id' => $this->knowledge_category_id,
            'video_link' => $this->video_link,
            'is_non_vimeo_event' => $this->is_non_vimeo_event,
            'is_payed_event' => $this->is_payed_event == '1',
            'upcoming_webinar_msg_sent' => false,
            'non_medical_event' => $this->non_medical_event,
            'is_survey_event' => $this->is_survey_event,
            'subsequent_survey' => $this->subsequent_survey,
            'show_in_home' => $this->show_in_home,
            'show_header_footer' => $this->show_header_footer,
            'send_sms' => $this->send_sms,
            'send_whatsapp' => $this->send_whatsapp,
            'send_email' => $this->send_email,
            'show_in_app' => $this->show_in_app,
            'show_hospital_name' => $this->show_hospital_name,
            'event_month' => $this->event_month,
            'session_end_time' => $this->session_end_time,
            'external_event' => $this->external_event,
            'certificate_id' => $this->certificate_id,
            'rewards' => $this->rewards,
            'quiz_id' => $this->quiz_id,
            'email_link' => $this->email_link,
            // 'password' => decrypt($this->password),
            'password_placeholder' => $this->password_placeholder,
            // 'moderator_password' => $this->moderator_password,
            'redirect_away_without_registration' => $this->redirect_away_without_registration,
            'subsequent_survey' => $this->subsequent_survey,
            'is_user_type' => $this->is_user_type,
            'is_speciality' => $this->is_speciality,
            'user_types' => !empty($this->user_types) ? json_decode($this->user_types) : null,
            'live_event_country' => !empty($this->live_event_country) ? ('+' . $this->live_event_country) : '+91',
            'is_mmc_number' => $this->is_mmc_number,
            'is_open_event' => $this->is_open_event,
            'hide_video' => $this->hide_video,
            'registration_tabs' => !empty($this->registration_tabs) ? json_decode($this->registration_tabs) : null,
            'community_for_registration' => !empty($this->community_for_registration) ? json_decode($this->community_for_registration) : null,
            'is_active' => $this->is_active,
            'active_chat' => $this->active_chat,
            'private_chat' => $this->private_chat,
            'sub_specialities' => $this->sub_specialities ?? null,
            'experts' => $this->experts ?? null,
            'banner_image' => !empty($this->banner_image) ? (config('constants.live_event_path'). $this->banner_image) : null,
            'mobile_banner_image' => !empty($this->mobile_banner_image) ? (config('constants.live_event_path'). $this->mobile_banner_image) : null,
            'register_image1' => !empty($this->register_image1) ? (config('constants.live_event_path'). $this->register_image1) : null,
            'register_image2' => !empty($this->register_image2) ? (config('constants.live_event_path'). $this->register_image2) : null,
            'thumbnail_image' => !empty($this->thumbnail_image) ? (config('constants.live_event_thumbnail_path'). $this->thumbnail_image) : null,
            'register_success_image' => !empty($this->register_success_image) ? (config('constants.live_event_path'). $this->register_success_image) : null,
            'event_completed_image' => !empty($this->event_completed_image) ? (config('constants.live_event_path'). $this->event_completed_image) : null,
            'feedback_survey' => $this->feedback_surveys,
            'payments' => $this->payments,
            'survey_type' => $this->survey_type,
            'has_certificates' => $this->has_certificates,
            'type' => $this->type
        ];
    }
}
