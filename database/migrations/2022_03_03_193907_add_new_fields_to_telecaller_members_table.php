<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToTelecallerMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->boolean('opted_in')->default(false);
            $table->unsignedInteger('history_id')->nullable();
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
            $table->dropColumn('opted_in');
            $table->dropColumn('history_id');
        });
    }
}
