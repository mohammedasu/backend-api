<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToTelecallerMemberCallHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_member_call_histories', function (Blueprint $table) {
            $table->boolean('in_call')->default(false);
            $table->integer('in_call_seconds')->default(0);
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
            $table->dropColumn('in_call');
            $table->dropColumn('in_call_seconds');
        });
    }
}
