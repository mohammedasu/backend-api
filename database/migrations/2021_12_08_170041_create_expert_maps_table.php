<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_maps', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('expert_id')->nullable(false);
            $table->foreign('expert_id')->references('id')->on('experts');

            $table->unsignedInteger('map_id')->nullable(false);

            $table->string('map_type')->nullable(false);

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
        Schema::dropIfExists('expert_maps');
    }
}
