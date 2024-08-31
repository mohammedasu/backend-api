<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_records', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('endpoint_map_id')->nullable();

            $table->bigInteger('mobile_number')->nullable(false);

            $table->longText('content')->nullable(false);

            $table->longText('response_code')->nullable(true);

            $table->foreign('endpoint_map_id')->references('id')->on('sms_endpoint_type_maps');

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
        Schema::dropIfExists('sms_records');
    }
}
