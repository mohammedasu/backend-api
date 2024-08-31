<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_endpoints', function (Blueprint $table) {
            $table->increments('id');

            $table->string('url', 200)->nullable(false);
            $table->string('key', 200)->nullable(false);
            $table->string('campaign', 200);
            $table->string('route_id', 200);
            $table->string('sender_name', 200)->nullable(false);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('sms_endpoints');
    }
}
