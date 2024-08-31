<?php

namespace App\Models;

use App\Constants\PaymentConstants;
use App\Http\Resources\FeedbackSurvey\FeedbackSurveyResource;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
class LiveEvent extends Model
{
   use SoftDeletes;

   protected $guarded = [];

   protected $appends = ['sub_specialities', 'experts', 'feedback_surveys', 'payments'];

   public function event_members()
   {
      return $this->hasMany(LiveEventMember::class,'link_id','id');
   }

   public function subscription(){
         return $this->hasOne(ContentSubscription::class,'content_id','id')->where('content_type',PaymentConstants::LIVE_EVENT);
   }

   public function member_certificates()
   {
      return $this->hasMany(MemberCertificate::class,'live_event_id','id');
   }

   public function expertmap()
   {
      return $this->hasMany(ExpertMap::class, 'map_id', 'id')->where('map_type', 'live_event');
   }

   public function feedbackSurvey()
   {
      return $this->hasMany(FeedbackSurvey::class, 'link_id', 'id');
   }

   public function ContentSubscription()
   {
      return $this->hasOne(ContentSubscription::class, 'content_id', 'id');
   }
   
   public function subSpecialityMap()
   {
      return $this->hasMany(SubSpecialityMap::class, 'map_id', 'id')->where('map_type', 'live_event');
   }

   public function getExpertsAttribute()
   {
      $data_maps = $this->expertmap ?? null;
      $data_maps = $data_maps->map(function ($item) {
         $expert_id =  $item->expert_id ?? null;
         return $expert_id;
      });
      return $this->attributes['experts'] = $data_maps;
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

   public function getFeedbackSurveysAttribute() {
      $survey = !empty($this->feedbackSurvey) ? FeedbackSurveyResource::collection($this->feedbackSurvey) : null;
      return $this->attributes['feedback_surveys'] = $survey;
   }

   public function getPaymentsAttribute() {
      $payment = !empty($this->ContentSubscription) ? $this->ContentSubscription : null;
      return $this->attributes['payments'] = $payment;

   }

}
