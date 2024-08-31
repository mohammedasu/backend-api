<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registration_id')->nullable(false);
            $table->string('member_name')->nullable(false);
            $table->boolean('completed_quiz')->default(false);
            $table->dateTime('quiz_start_time')->default(NOW());
            $table->dateTime('quiz_end_time')->nullable(true);
            $table->unsignedInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
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
        Schema::table('quiz_members', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
        });
        Schema::dropIfExists('quiz_members');
    }
}
