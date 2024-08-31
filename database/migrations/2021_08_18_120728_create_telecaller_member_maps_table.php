<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerMemberMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_member_maps', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('telecaller_id')->nullable(true);
            $table->foreign('telecaller_id')->references('id')->on('telecallers');

            $table->unsignedInteger('telecaller_member_id')->nullable(true);
            $table->foreign('telecaller_member_id')->references('id')->on('telecaller_members');
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
        Schema::dropIfExists('telecaller_member_maps');
    }
}
