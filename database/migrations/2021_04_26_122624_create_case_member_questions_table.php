<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseMemberQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_member_questions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('question_id')->nullable(false);
            $table->foreign('question_id')->references('id')->on('case_questions');

            $table->unsignedInteger('case_member_id')->nullable(false);
            $table->foreign('case_member_id')->references('id')->on('case_members');

            $table->boolean('is_correct')->default(false);

            $table->integer('answered_option')->nullable(true);

            $table->string('answer')->nullable(true);

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
        Schema::dropIfExists('case_member_questions');
    }
}
