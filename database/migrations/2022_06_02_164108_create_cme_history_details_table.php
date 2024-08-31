<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmeHistoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cme_history_details', function (Blueprint $table) {
            $table->id();
            $table->integer('cme_history_id');
            $table->integer('question_bank_id');
            $table->string('correct_answer')->nullable();
            $table->string('member_answer');
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
        Schema::dropIfExists('cme_history_details');
    }
}
