<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question  extends Model
{
    protected $guarded  = [];

    public function reference()
    {
        return $this->belongsTo(ReferenceQuestion::class,'id','question_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function replies()
    {
        return $this->hasMany(QuestionReply::class,'question_id','id')->whereNull('parent_id');
    }
    
}
