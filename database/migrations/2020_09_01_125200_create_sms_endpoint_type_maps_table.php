<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSEndpointTypeMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_endpoint_type_maps', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('endpoint_id')->nullable();

            $table->string('type', 50)->nullable(false);
            $table->longText('sms_content')->nullable(false);

            $table->string('placeholders', 50)->nullable(true)->default(null);

            $table->integer('validity')->default(null)->comment('Validity in minutes');

            $table->ipAddress('ip_address');

            $table->foreign('endpoint_id')->references('id')->on('sms_endpoints');

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
        Schema::dropIfExists('sms_endpoint_type_maps');
    }
}
