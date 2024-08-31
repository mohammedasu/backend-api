<?php

namespace App\Http\Resources\Cases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CasesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $trans = null;
        if(!empty($this->translation)) {
            $trans = json_decode($this->translation, true);
            if(isset($trans['indonesia']['image']) && !empty($trans['indonesia']['image'])) {
                $image = [];
                foreach ($trans['indonesia']['image'] as $key => $value) {
                    array_push($image,(config('constants.cases_path').$value));
                }
                $trans['indonesia']['image'] = $image;
            }
        }

        return [
            'id'                         => $this->id,
            'link_id'                    => $this->link_id,
            'title'                      => $this->title,
            'description'                => $this->description,
            'expert_id'                  => $this->expert_id,
            'community_id'               => $this->community_id,
            'partner_division_id'        => $this->partner_division_id,
            'is_active'                  => $this->is_active,
            'question_type'              => $this->question_type,
            'views'                      => $this->views,
            'view_multiplication_factor' => $this->view_multiplication_factor,
            'created_by_member_id'       => $this->created_by_member_id,
            'url_link'                   => $this->url_link,
            'country'                    => !empty($this->country) ? json_decode($this->country) : null,
            'tags'                       => !empty($this->tags) ? json_decode($this->tags) : null,
            "case_item"                  => !empty($this->case_items) ? $this->case_items : null,
            "community"                  => !empty($this->case_community_maps) ? $this->case_community_maps : null,
            "questions"                  => !empty($this->case_questions) ? $this->case_questions : null,
            "comments"                   => !empty($this->case_comments) ? $this->case_comments : null,
            'knowledge_category'         => $this->case_knowledge_categories,
            'sub_specialities'           => $this->sub_specialities,
            'meta_title'                 => $this->meta_title,
            'meta_desc'                  => $this->meta_desc,
            'meta_keywords'              => $this->meta_keywords,
            'translation'                => $trans,
        ];
    }
}
