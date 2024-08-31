<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseItems extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['image_name','case_id','ip_address'];

    public function cases()
    {
        return $this->belongsTo(Cases::class,'case_id','id');
    }

    public function scopeSelectItem($query){
        return $query->select(['id','image_name']);
    }

}
