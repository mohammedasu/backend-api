<?php

namespace App\Http\Resources\Cme;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\QuestionBank\QuestionBankMapResource;

class CmeResource extends JsonResource
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
            'id'                            => $this->id,
            'type'                          => $this->type,
            'name'                          => $this->name,
            'points'                        => $this->points,
            'description'                   => $this->description,
            'heading_text'                  => $this->heading_text,
            'survey_url'                    => $this->survey_url,
            'survey_background_image'       => !empty($this->survey_background_image) ? (config('constants.cme_path') . $this->survey_background_image) : null,
            'passing_criteria'              => $this->passing_criteria,
            'pass_text'                     => $this->pass_text,
            'pass_image'                    => !empty($this->pass_image) ? (config('constants.cme_path') . $this->pass_image) : null,
            'pass_button_text'              => $this->pass_button_text,
            'fail_text'                     => $this->fail_text,
            'fail_image'                    => !empty($this->fail_image) ? (config('constants.cme_path') . $this->fail_image) : null,
            'fail_button_text'              => $this->fail_button_text,
            'show_landing_page'             => $this->show_landing_page,
            'show_result'                   => $this->show_result,
            'allow_back'                    => $this->allow_back,
            'allow_retest'                  => $this->allow_retest,
            'download_certificate'          => $this->download_certificate,
            'certificate_template_id'       => $this->certificate_template_id,
            'status'                        => $this->status,
            'timer_status'                  => $this->timer_status, // 0   => in active, 1   => on module, 3   => on questions
            'time_in_seconds'               => $this->time_in_seconds,
            'negative_marks_status'         => $this->negative_marks_status,
            'negative_mark'                 => $this->negative_mark,
            'positive_mark'                 => $this->positive_mark,
            'landing_page_button_text'      => $this->landing_page_button_text,
            'landing_page_image'            => !empty($this->landing_page_image) ? (config('constants.cme_path') . $this->landing_page_image) : null,
            'survey_background_mobile_image' => !empty($this->survey_background_mobile_image) ? (config('constants.cme_path') . $this->survey_background_mobile_image) : null,
            'registration_template_id'      => $this->registration_template_id,
            'cme_questions'                 => QuestionBankMapResource::collection($this->questions),
            'cme_attachment'                => $this->attachments,
            'survey_coins'                  => $this->survey_coins,
            'coins'                         => $this->coins,
            'coins_type'                    => $this->coins_type,
            'show_rand_questions'           => $this->show_rand_questions,
            'allowed_members_from'          => $this->allowed_members_from,
            'members_csv_file'              => !empty($this->members_csv_file) ? (config('constants.cme_path') . $this->members_csv_file) : null,
            'data_filter_id'                => $this->data_filter_id,
        ];
    }
}
