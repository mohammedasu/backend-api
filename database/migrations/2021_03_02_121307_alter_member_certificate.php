<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemberCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_certificates', function (Blueprint $table) {
            $table->longText('image_name')->nullable(false);
            $table->longText('file_name')->nullable(false)->change();

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
            $table->dropColumn('image_name');
            $table->string('file_name')->change();

        });
    }
}
