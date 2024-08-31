<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingMailSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_mail_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('mail_id');
            $table->string('ip_address');
            $table->string('mail_type');
            $table->timestamp('dispatch_time');
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('marketing_mail_schedules');
    }
}
