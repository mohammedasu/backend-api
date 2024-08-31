<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialities', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('community_id');

            $table->string('title', 50)->nullable(false);

            $table->string('image')->nullable();

            $table->string('description')->nullable();

            $table->boolean('is_available_for_registration')->default(true);

            $table->foreign('community_id')->references('id')->on('communities');

            $table->boolean('is_active')->default(true);

            $table->ipAddress('ip_address')->nullable();

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
        Schema::dropIfExists('specialities');
    }
}
