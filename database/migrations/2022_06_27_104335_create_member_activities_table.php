<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('reference_type');
            $table->integer('reference_id');
            $table->integer('useful')->default(0);
            $table->integer('like')->default(0);
            $table->integer('bookmark')->default(0);
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
        Schema::dropIfExists('member_activities');
    }
}
