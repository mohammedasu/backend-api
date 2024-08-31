<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryCodeInTelecallerMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->string('country_code')->nullable(true);
            $table->string('country')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->dropColumn('country');
        });
    }
}
