<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtalksClickThroughReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtalks_click_through_report', function (Blueprint $table) {
            $table->increments('id');

            $table->string("mobile")->nullable(true);
            $table->string("campaignName")->nullable(true);
            $table->string("browser")->nullable(true);
            $table->string("platform")->nullable(true);
            $table->string("count")->nullable(true);
            $table->string("ip")->nullable(true);
            $table->string("city")->nullable(true);

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
        Schema::dropIfExists('mtalks_click_through_report');
    }
}
