<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationMaster extends Model
{
    use SoftDeletes;
    
    protected $table = 'notification_master';
    
    protected $guarded = [];

    //Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //appends
    public function email_template_name() {
        return $this->hasOne(NotificationTemplate::class, 'template_ref_no', 'email_template_ref_no');
    }

    public function sms_template_name() {
        return $this->hasOne(NotificationTemplate::class, 'template_ref_no', 'sms_template_ref_no');
    }

    public function push_template_name() {
        return $this->hasOne(NotificationTemplate::class, 'template_ref_no', 'push_notification_template_ref_no');
    }

    public function page_template_name() {
        return $this->hasOne(NotificationTemplate::class, 'template_ref_no', 'page_notification_template_ref_no');
    }
}
