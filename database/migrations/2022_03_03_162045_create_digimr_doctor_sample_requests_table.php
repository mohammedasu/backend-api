<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigiMrDoctorSampleRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digimr_doctor_sample_requests', function (Blueprint $table) {
            $table->id();
            $table->json('skus');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('digimr_id')->nullable();
            $table->unsignedInteger('digimr_doctor_id')->nullable();
            $table->unsignedInteger('call_history_id')->nullable();
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
        Schema::dropIfExists('digimr_doctor_sample_requests');
    }
}
