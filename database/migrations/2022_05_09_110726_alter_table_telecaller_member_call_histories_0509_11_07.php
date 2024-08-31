<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTelecallerMemberCallHistories05091107 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_member_call_histories', function (Blueprint $table) {
            $table->tinyInteger('is_raised_request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecaller_member_call_histories', function (Blueprint $table) {
            $table->dropColumn('is_raised_request');
        });
    }
}
