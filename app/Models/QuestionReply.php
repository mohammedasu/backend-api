<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionReply  extends Model
{
    protected $guarded  = [];

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function replies()
    {
        return $this->hasMany(QuestionReply::class,'parent_id','id');
    }

}
