<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerMemberUpdationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_member_updation_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('telecaller_id');
            $table->unsignedBigInteger('telecaller_member_id');
            $table->json('updates')->nullable();
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
        Schema::dropIfExists('telecaller_member_updation_histories');
    }
}
