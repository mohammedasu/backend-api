<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToMemberVerifybyWhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_verifyby_who', function (Blueprint $table) {
            $table->index('mci_user_status');
            $table->index('mci_reg_status');
            $table->index('mci_state_status');
            $table->index('mci_year_status');
            $table->index('verified_status');
            $table->index('verified_by');
            $table->index('verified_by_id');
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
            $table->dropIndex(['mci_user_status']);
            $table->dropIndex(['mci_reg_status']);
            $table->dropIndex(['mci_state_status']);
            $table->dropIndex(['mci_year_status']);
            $table->dropIndex(['verified_status']);
            $table->dropIndex(['verified_by']);
            $table->dropIndex(['verified_by_id']);
        });
    }
}
