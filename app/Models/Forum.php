<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{
    use SoftDeletes;
    protected $table = 'partner_divisions';
    protected $guarded = [];
    protected $appends = ['community_selected', 'sub_specialities', 'council_experts', 'other_experts'];


    protected $casts = [
        'forum_tabs' => 'array',
        'cta_data' => 'array',

    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeTrash($query)
    {
        return $query->whereNotNull('deleted_at');
    }
    public function getImageNameAttribute()
    {
        $response = null;
        if (isset($this->attributes['image_name'])) {

            $response = config('constants.partner_image_path') . $this->attributes['image_name'];
        }
        return $this->attributes['image_name'] = $response;
    }
    public function getWebsiteBannerImageAttribute()
    {
        $response = null;
        if (isset($this->attributes['website_banner_image'])) {

            $response = config('constants.partner_image_path') . $this->attributes['website_banner_image'];
        }
        return $this->attributes['website_banner_image'] = $response;
    }
    public function getPreLoginImageAttribute()
    {
        $response = null;
        if (isset($this->attributes['pre_login_image'])) {

            $response = config('constants.partner_image_path') . $this->attributes['pre_login_image'];
        }
        return $this->attributes['pre_login_image'] = $response;
    }
    public function getPreLoginImage2Attribute()
    {
        $response = null;
        if (isset($this->attributes['pre_login_image2'])) {

            $response = config('constants.partner_image_path') . $this->attributes['pre_login_image2'];
        }
        return $this->attributes['pre_login_image2'] = $response;
    }
    public function getThumbnailImageAttribute()
    {
        $response = null;
        if (isset($this->attributes['thumbnail_image'])) {

            $response = config('constants.partner_image_path') . $this->attributes['thumbnail_image'];
        }
        return $this->attributes['thumbnail_image'] = $response;
    }

    public function getKnowledgeAcademyBannerImageAttribute()
    {
        $response = null;
        if (isset($this->attributes['knowledge_academy_banner_image'])) {

            $response = config('constants.partner_image_path') . $this->attributes['knowledge_academy_banner_image'];
        }
        return $this->attributes['knowledge_academy_banner_image'] = $response;
    }
    public function getKnowledgeAcademyBannerImageMobileAttribute()
    {
        $response = null;
        if (isset($this->attributes['knowledge_academy_banner_image_mobile'])) {

            $response = config('constants.partner_image_path') . $this->attributes['knowledge_academy_banner_image_mobile'];
        }
        return $this->attributes['knowledge_academy_banner_image_mobile'] = $response;
    }
    public function getThumbnailImageLogoAttribute()
    {
        $response = null;
        if (isset($this->attributes['thumbnail_image_logo'])) {

            $response = config('constants.partner_image_path') . $this->attributes['thumbnail_image_logo'];
        }
        return $this->attributes['thumbnail_image_logo'] = $response;
    }
    public function communityMap()
    {
        return $this->hasMany(CommunityMap::class, 'map_id', 'id')->where('map_type', '=', 'partner_division');
    }

    public function subSpecialityMap()
    {
        return $this->hasMany(SubSpecialityMap::class, 'map_id', 'id')->where('map_type', 'partner_division');
    }
    public function councilExpertMap()
    {
        return $this->hasMany(ExpertMap::class, 'map_id', 'id')->where('map_type', 'forum_council_expert');
    }
    public function otherExpertMap()
    {
        return $this->hasMany(ExpertMap::class, 'map_id', 'id')->where('map_type', 'forum_other_expert');
    }
    public function subSpeciality()
    {
        return $this->hasManyThrough(
            SubSpeciality::class,
            SubSpecialityMap::class,
            'map_id',
            'id',
            'id',
            'sub_speciality_id'
        )->orderBy('name', 'ASC')->where('map_type', 'partner_division');
    }

    public function privacyRules()
    {
        return $this->hasMany(PrivateForumRule::class, 'forum_id', 'id');
    }

    public function getCommunitySelectedAttribute()
    {
        $community_maps = $this->communityMap ?? null;
        $communities = $community_maps->map(function ($item) {
            $community =  $item->community ?? null;
            if ($community) {
                $community_response['id'] = $community->id;
                $community_response['title'] = $community->title;
                return  $community_response;
            }
        });
        return $this->attributes['community_selected'] = $communities;
    }
    public function getCouncilExpertsAttribute()
    {
        $council_maps = $this->councilExpertMap ?? null;
        $council_maps = $council_maps->map(function ($item) {
            $expert_id =  $item->expert_id ?? null;
            return $expert_id;
        });
        return $this->attributes['council_experts'] = $council_maps;
    }
    public function getOtherExpertsAttribute()
    {
        $other_expert_maps = $this->otherExpertMap ?? null;
        $other_maps = $other_expert_maps->map(function ($item) {
            $expert_id =  $item->expert_id ?? null;
            return $expert_id;
        });
        return $this->attributes['other_experts'] = $other_maps;
    }
}
