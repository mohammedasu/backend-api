<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type', 50)->nullable(false);

            $table->unsignedInteger('video_id')->nullable();

            $table->foreign('video_id')->references('id')->on('videos');

            $table->integer('number_of_questions')->nullable(false);

            $table->boolean('is_active')->default(true);

            $table->string('description', 500)->nullable(true);

            $table->string('link_name')->nullable(true);

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
        Schema::dropIfExists('quiz');
    }
}
