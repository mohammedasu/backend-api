<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOpenForumInPartnerDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {
            $table->boolean('is_open_forum')->default(false);
        });

        Schema::table('newsletters', function (Blueprint $table) {
            $table->boolean('is_open_newsletter')->default(false);
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
            $table->dropColumn('is_open_forum');
        });

        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropColumn('is_open_newsletter');
        });
    }
}
