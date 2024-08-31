<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->string('website_banner_image')->nullable(true);
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->string('website_banner_image')->nullable(true);
        });

        Schema::table('partner_divisions', function (Blueprint $table) {
            $table->string('website_banner_image')->nullable(true);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('website_banner_image');
        });
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('website_banner_image');
        });
        Schema::table('partner_divisions', function (Blueprint $table) {
            $table->dropColumn('website_banner_image');
        });
    }
}
