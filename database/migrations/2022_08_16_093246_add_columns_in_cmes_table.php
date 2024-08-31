<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->integer('show_rand_questions')->default(0);
            $table->integer('created_by')->nullable();
            $table->string('created_from')->nullable();
            $table->enum('allowed_members_from', ['data_filter', 'csv','all'])->default('all');
            $table->string('members_csv_file')->nullable();
            $table->unsignedInteger('data_filter_id')->nullable();
            $table->foreign('data_filter_id')->references('id')->on('data_filters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->dropForeign(['data_filter_id']);
            $table->dropColumn(['show_rand_questions', 'created_by', 'created_from', 'allowed_members_from', 'members_csv_file', 'data_filter_id']);
        });
    }
}
