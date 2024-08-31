<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->dropColumn('pass_url');
            $table->dropColumn('fail_url');
            $table->string('pass_text')->nullable();
            $table->string('fail_text')->nullable();
            $table->string('survey_background_image')->nullable();
            $table->string('pass_image')->nullable();
            $table->string('fail_image')->nullable();
            $table->boolean('download_certificate')->default('0');
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
            $table->string('pass_url')->nullable();
            $table->string('fail_url')->nullable();
            $table->dropColumn('pass_text');
            $table->dropColumn('fail_text');
            $table->dropColumn('survey_background_image');
            $table->dropColumn('pass_image');
            $table->dropColumn('fail_image');
            $table->dropColumn('download_certificate');
        });
    }
}
