<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->boolean('member_type')->default(0);
            $table->longText('reply');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('reported_spam')->default(false);
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
        Schema::dropIfExists('question_replies');
    }
}
