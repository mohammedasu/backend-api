<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTelecallerMemberCallHistoriesTable13041117 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_member_call_histories', function (Blueprint $table) {
            $table->string('calling_number')->nullable();
            $table->string('phone_code')->nullable();
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
            $table->dropColumn('calling_number');
            $table->dropColumn('phone_code');
        });
    }
}
