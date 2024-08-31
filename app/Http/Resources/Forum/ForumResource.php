<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            'id'    => $this->id,
            'title' => $this->name,
            'link_name' => $this->link_name,
            'partner_id' => $this->partner_id,
            'description' => $this->description,
            'pre_login_description' => $this->pre_login_description,
            'discussion' => $this->discussion,
            'is_open_forum' => $this->is_open_forum,
            'forum_type' => $this->forum_type,
            'geographic_type' => $this->geographic_type,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            "forum_visibility" => $this->forum_visibility,
            "show_followers" => $this->show_followers,
            "is_active" => $this->is_active,
            "image_name" => $this->image_name,
            "website_banner_image" => $this->website_banner_image,
            "pre_login_image" => $this->pre_login_image,
            "pre_login_image2" => $this->pre_login_image2,
            "thumbnail_image" => $this->thumbnail_image,
            "thumbnail_image_logo" => $this->thumbnail_image_logo,
            "community" => $this->community_selected,
            "sub_specialities" => $this->subSpeciality,
            "user_types" => $this->user_types,
            "forum_manager" => $this->forum_manager,
            "brand_page_link_text" => $this->brand_page_link_text,
            "brand_page_link" => $this->brand_page_link,
            "forum_council_expert_text" => $this->forum_council_expert_text,
            "forum_other_expert_text" => $this->forum_other_expert_text,
            "council_experts" => $this->council_experts,
            "other_experts" => $this->other_experts,
            "is_knowledge_academy_active" => $this->is_knowledge_academy_active,
            "knowledge_academy_to_address" => $this->knowledge_academy_to_address,
            "interested_in_grant_text" => $this->interested_in_grant_text,
            "reaching_out_text" => $this->reaching_out_text,
            "external_link" => $this->external_link,
            "knowledge_academy_name" => $this->knowledge_academy_name,
            "knowledge_academy_header_text" => $this->knowledge_academy_header_text,
            "knowledge_academy_thank_you_message" => $this->knowledge_academy_thank_you_message,
            "knowledge_academy_banner_image_mobile" => $this->knowledge_academy_banner_image_mobile,
            "knowledge_academy_banner_image" => $this->knowledge_academy_banner_image,
            "privacy_rules" => $this->privacyRules,
            "cta_data" => $this->cta_data,
            "forum_tabs" => $this->forum_tabs


        ];
    }
}
