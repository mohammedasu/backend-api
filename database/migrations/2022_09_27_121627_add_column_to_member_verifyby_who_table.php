<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMemberVerifybyWhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_verifyby_who', function (Blueprint $table) {
            $table->boolean('mci_year_status')->default(false);
            $table->string('mci_reg_percent_match')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_verifyby_who', function (Blueprint $table) {
            $table->dropColumn(['mci_year_status', 'mci_reg_percent_match']);
        });
    }
}
