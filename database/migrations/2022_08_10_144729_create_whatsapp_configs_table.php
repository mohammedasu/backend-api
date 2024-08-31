<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_id');
            $table->string('ref_type');
            $table->unsignedInteger('endpoint_id');
            $table->foreign('endpoint_id')->references('id')->on('sms_endpoints');
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
        Schema::dropIfExists('whatsapp_configs');
    }
}
