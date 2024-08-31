<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_responses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedInteger('quiz_item_id')->nullable();
            $table->foreign('quiz_item_id')->references('id')->on('quiz_items');

            $table->longText('answer')->nullable(false);

            $table->boolean('correct_answer')->default(false);

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
        Schema::dropIfExists('quiz_responses');
    }
}
