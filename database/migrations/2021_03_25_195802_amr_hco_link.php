<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmrHcoLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amr_hco_link', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title')->nullable(false);

            $table->string('link')->nullable(false);

            $table->unsignedInteger('amr_hco_id')->nullable();

            $table->foreign('amr_hco_id')->references('id')->on('amr_hco');

            $table->timestamps();

            $table->ipAddress('ip_address')->nullable(false);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amr_hco_link');

    }
}
