<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPointHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_point_histories', function (Blueprint $table) {
            $table->id();
            $table->string('member_type');
            $table->integer('member_id');
            $table->string('content_type');
            $table->integer('content_id');
            $table->string('points_type');
            $table->integer('points')->default(0);
            $table->string('point_credit_debit');
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
        Schema::dropIfExists('member_point_histories');
    }
}
