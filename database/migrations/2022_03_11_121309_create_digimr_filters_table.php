<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDigimrFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digimr_filters', function (Blueprint $table) {
            $table->id();
            $table->json('project_filters');
            $table->json('doctor_filters');
            $table->unsignedInteger('telecaller_id');
            $table->foreign('telecaller_id')->references('id')->on('telecallers')->cascadeOnDelete();
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
        Schema::dropIfExists('digimr_filters');
    }
}
