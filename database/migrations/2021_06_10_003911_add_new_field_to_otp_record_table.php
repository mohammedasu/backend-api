<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToOtpRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otp_records', function (Blueprint $table) {
            $table->integer('rate_limit')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('otp_records', function (Blueprint $table) {
            $table->dropColumn('rate_limit');
            $table->dropColumn('ip_address');
            $table->dropColumn('country_code');
        });
    }
}
