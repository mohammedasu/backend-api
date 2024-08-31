<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionBankAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_bank_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_bank_map_id');
            $table->unsignedBigInteger('member_id');
            $table->string('member_type');
            $table->unsignedBigInteger('question_bank_id');
            $table->string('answer');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_bank_answers');
    }
}
