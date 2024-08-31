<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToQuestionBankMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_bank_maps', function (Blueprint $table) {
            $table->integer('show_answer')->after('map_type');
            $table->integer('show_answer_details')->after('show_answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_bank_maps', function (Blueprint $table) {
            $table->dropColumn('show_answer');
            $table->dropColumn('show_answer_details');
        });
    }
}
