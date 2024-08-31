<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cme extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionBankMap::class, 'map_id', 'id')->where('map_type', 'cme');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(CmeMap::class, 'cme_id', 'id');
    }
}
