<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTelecallerMembers22091159 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->unsignedInteger("lc_telecaller_id")->nullable();
            $table->unsignedInteger("lc_project_id")->nullable();
            $table->unsignedInteger("lc_history_id")->nullable();
            $table->datetime("lc_start_time")->nullable();
            $table->unsignedInteger("lc_rating")->nullable();
            $table->text("lc_notes")->nullable();
            $table->string("lc_status");
            $table->string("lc_project_name")->nullable();
            $table->string("lc_telecaller_name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->dropColumn('lc_telecaller_id');
            $table->dropColumn('lc_project_id');
            $table->dropColumn('lc_history_id');
            $table->dropColumn('lc_start_time');
            $table->dropColumn('lc_rating');
            $table->dropColumn('lc_notes');
            $table->dropColumn('lc_status');
            $table->dropColumn('lc_project_name');
            $table->dropColumn('lc_telecaller_name');
        });
    }
}
