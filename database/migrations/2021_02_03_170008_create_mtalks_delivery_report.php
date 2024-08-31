<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtalksDeliveryReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtalks_delivery_report', function (Blueprint $table) {
            $table->increments('id');

            $table->string("msgid")->nullable(true);
            $table->string("campaignName")->nullable(true);
            $table->string("errorCode")->nullable(true);
            $table->string("dlrTime")->nullable(true);
            $table->string("mobile")->nullable(true);
            $table->string("senderid")->nullable(true);
            $table->string("status")->nullable(true);
            $table->string("add_param")->nullable(true);

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
        Schema::dropIfExists('mtalks_delivery_report');
    }
}
