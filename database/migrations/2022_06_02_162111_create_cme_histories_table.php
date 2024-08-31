<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cme_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->integer('cme_id');
            $table->string('type')->nullable();
            $table->integer('type_id')->nullable();
            $table->double('result_in_percent')->default(0);
            $table->integer('earned_points')->default(0);
            $table->double('earned_coins')->default(0);
            $table->enum('earned_coins_type',['coin','cash'])->nullable();
            $table->integer('is_passed')->default(0);
            $table->integer('total_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('attempt_number')->default(1);
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
        Schema::dropIfExists('cme_histories');
    }
}
