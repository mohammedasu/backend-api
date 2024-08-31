<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeTaken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_members', function (Blueprint $table) {
            $table->integer('time_taken')->nullable();
            $table->integer('total_questions')->nullable();
            $table->integer('correct_answers')->nullable();

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
            Schema::dropIfExists('time_taken');
            Schema::dropIfExists('total_questions');
            Schema::dropIfExists('correct_answers');
        });
    }
}
