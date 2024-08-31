<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMemberCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_certificates', function (Blueprint $table) {
            $table->string('mobile_number')->nullable();
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
        Schema::table('member_certificates', function (Blueprint $table) {
            // $table->dropColumn('mobile_number');
            // $table->dropColumn('country_code');
        });
    }
}
