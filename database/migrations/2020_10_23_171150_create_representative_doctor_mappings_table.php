<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativeDoctorMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representative_doctor_mappings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('doctor_name')->nullable(false);
            $table->string("doctor_mobile_number",20)->nullable(true);
            $table->string('doctor_email')->nullable(true);
            $table->string('rep_name')->nullable(false);
            $table->string("rep_mobile_number",20)->nullable(false);
            $table->string('rep_email')->nullable(false);
            $table->longText('url')->nullable(false);
            $table->string('video_id')->nullable(false);
            $table->string('share_via')->nullable(false);
            $table->dateTime('time_of_share')->default(now());

            $table->softDeletes();

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
        Schema::dropIfExists('representative_doctor_mappings');
    }
}
