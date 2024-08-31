<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_points', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('member_type');
            $table->integer('total_points')->default(0);;
            $table->integer('redeem_points')->default(0);;
            $table->integer('available_points')->default(0);;
            $table->double('total_cash')->default(0);;
            $table->double('redeem_cash')->default(0);;
            $table->double('available_cash')->default(0);;
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('member_points');
    }
}
