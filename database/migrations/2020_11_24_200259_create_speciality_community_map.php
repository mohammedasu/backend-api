<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialityCommunityMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speciality_community_map', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('speciality_id')->nullable();
            $table->foreign('speciality_id')->references('id')->on('specialities');

            $table->unsignedInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities');


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
        Schema::dropIfExists('speciality_community_map');
    }
}
