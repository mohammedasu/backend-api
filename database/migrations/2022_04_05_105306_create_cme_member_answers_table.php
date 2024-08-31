<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmeMemberAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cme_member_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->default(0);
            $table->integer('cme_id')->default(0);
            $table->integer('member_id')->default(0);
            $table->string('answer')->nullable();
            $table->integer('attempt_number')->default(0);
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
        Schema::dropIfExists('cme_member_answers');
    }
}
