<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('quiz_id')->nullable();
            $table->foreign('quiz_id')->references('id')->on('quiz');

            $table->longText('question')->nullable(false);

            $table->longText('answer')->nullable(true);

            $table->enum('type_of_question', ['mcq', 'free_field'])->default('mcq');

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
        Schema::dropIfExists('quiz_items');
    }
}
