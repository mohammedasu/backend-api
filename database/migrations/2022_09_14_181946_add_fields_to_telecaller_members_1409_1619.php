<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTelecallerMembers14091619 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->unsignedInteger('added_by_telecaller_id')->nullable();

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
            $table->dropColumn('added_by_telecaller_id');
        });
    }
}
