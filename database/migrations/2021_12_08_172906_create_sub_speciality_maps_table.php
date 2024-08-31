<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSpecialityMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_speciality_maps', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('sub_speciality_id')->nullable(false);
            $table->foreign('sub_speciality_id')->references('id')->on('sub_specialities');

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
        Schema::dropIfExists('sub_speciality_maps');
    }
}
