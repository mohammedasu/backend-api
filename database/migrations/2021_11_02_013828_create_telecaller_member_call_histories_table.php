<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerMemberCallHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_member_call_histories', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->integer('call_time_in_sec')->nullable();
            $table->unsignedBigInteger('telecaller_id');
            $table->unsignedBigInteger('telecaller_member_id');
            $table->unsignedInteger('calendar_event')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->string('product_call_status')->nullable();
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
        Schema::dropIfExists('telecaller_member_call_histories');
    }
}
