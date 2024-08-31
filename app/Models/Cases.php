<?php

namespace App\Models;

use App\Community;
use App\Expert;
use App\Http\Resources\CaseComment\CaseCommentResource;
use App\Http\Resources\CaseItem\CaseItemResource;
use App\Http\Resources\CaseQuestion\CaseQuestionResource;
use App\Http\Resources\CommunityMap\CommunityMapResource;
use App\Http\Resources\KnowledgeCategoryItem\KnowledgeCategoryItemResource;
use App\Member;
use App\PartnerDivision;
use App\Models\ReferenceQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MemberBookmark;

class Cases extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TRAITS
    |--------------------------------------------------------------------------
    */

    use HasFactory, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'title',
        'description',
        'expert_id',
        'ip_address',
        'link_id',
        'community_id',
        'partner_division_id',
        'question_type',
        'view_multiplication_factor',
        'created_by_member_id',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'created_by',
        'created_from',
        'is_active',
        'country',
        'tags',
        'translation'
    ];

    protected $appends = ['case_items','case_community_maps','case_questions', 'case_comments', 'sub_specialities', 'case_knowledge_categories'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function items(){
        return $this->hasMany(CaseItems::class,'case_id','id');
    }

    public function case_item(){
        return $this->hasOne(CaseItems::class,'case_id','id');
    }

    public function latestItem(){
        return $this->hasOne(CaseItems::class,'case_id','id')->latestOfMany();
    }

    public function questions(){
        return $this->hasMany(CaseQuestions::class, 'case_id','id')->with('memberQuestions');
    }

    public function expert(){
        return $this->hasOne(Expert::class, 'id','expert_id');
    }

    public function refrence()
    {
        return $this->hasMany(ReferenceQuestion::class,'reference_id','id')->where('refrence_type','cases');
    }

    public function community(){
        return $this->hasOne(Community::class, 'id','community_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,'reference_id','id')->where('reference_type','cases')/*->whereNull('parent_id')*/;
    }

    public function members()
    {
        return $this->hasMany(CaseMembers::class, 'case_id', 'id');
    }

    public function forum()
    {
        return $this->hasOne(PartnerDivision::class,'id','partner_division_id');
    }

    public function createdMember(){
        return $this->belongsTo(Member::class, 'created_by_member_id','id')->with('speciality');
    }

    public function communityMap()
    {
        return $this->hasMany(CommunityMap::class, 'map_id','id')->where('map_type','cases');
    }

    public function cases_question()
    {
        return $this->hasMany(CommunityMap::class, 'map_id','id')->where('map_type','cases');
    }

    public function bookmarks()
    {
        return $this->hasOne(MemberBookmark::class,'reference_id','id')->where('reference_type','cases');
    }

    public function subSpecialityMap(){
        return $this->hasMany(SubSpecialityMap::class, 'map_id','id')->where('map_type','cases');
    }

    public function knowledgeCategory(){
        return $this->hasMany(KnowledgeCategoryItems::class, 'type_id', 'id')->where('type', 'cases');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeSelectColumns($query)
    {
        return $query->select(['id', 'link_id', 'title', 'description', 'expert_id']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getTotalUsefulAttribute()
    {
        return $this->members()->useful()->count();
    }

    public function getTotalAnswerAttribute()
    {
        return $this->members()->answer()->count();
    }

    public function getSubSpecialitiesAttribute()
    {
        $data_maps = $this->subSpecialityMap ?? null;
        $data_maps = $data_maps->map(function ($item) {
            $sub_speciality_id =  $item->sub_speciality_id ?? null;
            return $sub_speciality_id;
        });
        return $this->attributes['sub_specialities'] = $data_maps;
    }

    public function getCaseItemsAttribute()
    {
        $case_items = $this->items ? CaseItemResource::collection($this->items) : null;
        return $this->attributes['case_items'] = $case_items;
    }

    public function getCaseCommunityMapsAttribute()
    {
        $community_maps = $this->communityMap ? CommunityMapResource::collection($this->communityMap) : null;
        return $this->attributes['case_community_maps'] = $community_maps;
    }

    public function getCaseQuestionsAttribute()
    {
        $questions = $this->questions ? CaseQuestionResource::collection($this->questions) : null;
        return $this->attributes['case_questions'] = $questions;
    }

    public function getCaseCommentsAttribute()
    {
        $questions = $this->questions ? CaseCommentResource::collection($this->comments) : null;
        return $this->attributes['case_comments'] = $questions;
    }

    public function getCaseKnowledgeCategoriesAttribute()
    {
        $knowledge_cats = $this->knowledgeCategory ? KnowledgeCategoryItemResource::collection($this->knowledgeCategory) : null;
        return $this->attributes['case_knowledge_categories'] = $knowledge_cats;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
