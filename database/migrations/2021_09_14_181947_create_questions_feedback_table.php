<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('insightful')->default(0);
            $table->integer('like')->default(0);
            $table->boolean('report_spam')->default(false);
            $table->text('spam_description')->nullable();
            $table->unsignedInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('reply_id')->nullable();
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
        Schema::dropIfExists('questions_feedback');
    }
}
