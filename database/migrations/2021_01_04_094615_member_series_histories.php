<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MemberSeriesHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_series_histories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedInteger('series_id')->nullable();
            $table->foreign('series_id')->references('id')->on('series');

            $table->boolean('liked')->default(false);
            $table->boolean('insightful')->default(false);

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
        Schema::dropIfExists('member_series_histories');
    }
}
