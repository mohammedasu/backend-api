<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_questions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('question')->nullable(false);

            $table->json('option');

            $table->string('answer')->nullable(true);

            $table->integer('correct_option')->nullable(true);

            $table->enum('type', ['mcq','discussion_forum'])->default('mcq');

            $table->unsignedInteger('case_id');
            $table->foreign('case_id')->references('id')->on('cases');

            //todo : add foreign key
            $table->unsignedInteger('discussion_forum_id')->nullable(true);
//            $table->foreign('case_id')->references('id')->on('cases');

            $table->timestamp('show_answer_at')->nullable(true);

            $table->longText('answer_details')->nullable(true);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('case_questions');
    }
}
