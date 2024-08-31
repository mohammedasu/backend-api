<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_master', function (Blueprint $table) {
            $table->id();
            $table->string('notification_master_ref_no', 30)->unique();
            $table->string('event_name');
            $table->string('email_template_ref_no')->nullable();
            $table->foreign('email_template_ref_no')->references('template_ref_no')->on('notification_templates');
            $table->string('sms_template_ref_no')->nullable();
            $table->foreign('sms_template_ref_no')->references('template_ref_no')->on('notification_templates');
            $table->string('push_notification_template_ref_no')->nullable();
            $table->foreign('push_notification_template_ref_no')->references('template_ref_no')->on('notification_templates');
            $table->string('page_notification_template_ref_no')->nullable();
            $table->foreign('page_notification_template_ref_no')->references('template_ref_no')->on('notification_templates');
            $table->integer('is_active')->default(1);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_master');
    }
}
