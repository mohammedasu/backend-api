<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToThreeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {
            $table->longText('pre_login_description')->nullable();
            $table->string('brand_page_link_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {
            $table->dropColumn('pre_login_description');
            $table->dropColumn('brand_page_link_text');
        });
    }
}
