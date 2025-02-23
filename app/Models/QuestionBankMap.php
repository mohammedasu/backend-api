<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionBankMap extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function question_details()
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_id', 'id');
    }
}
