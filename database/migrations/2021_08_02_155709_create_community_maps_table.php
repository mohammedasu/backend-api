<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_maps', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('community_id')->nullable(false);
            $table->foreign('community_id')->references('id')->on('communities');

            $table->unsignedInteger('map_id')->nullable(false);

            $table->enum('map_type', ['video', 'cases','expert'])->default('video');

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
        Schema::dropIfExists('community_maps');
    }
}
