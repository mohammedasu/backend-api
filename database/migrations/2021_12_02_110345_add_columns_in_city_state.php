<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCityState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('city_state', function (Blueprint $table) {
            $table->string('tier')->nullable(true);
            $table->string('metro_type')->nullable(true);
            $table->string('class')->nullable(true);
            $table->string('zone')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('city_state', function (Blueprint $table) {
            $table->dropColumn('tier');
            $table->dropColumn('metro_type');
            $table->dropColumn('class');
            $table->dropColumn('zone');
        });
    }
}
