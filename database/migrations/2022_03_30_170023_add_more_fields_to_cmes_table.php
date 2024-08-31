<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToCmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->string('survey_url')->nullable();
            $table->string('pass_button_text')->nullable();
            $table->string('pass_url')->nullable();
            $table->string('fail_button_text')->nullable();
            $table->string('fail_url')->nullable();
            $table->string('type')->nullable();
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
            $table->dropColumn(['survey_url','pass_button_text','pass_url','fail_button_text','fail_url','type']);
        });
    }
}
