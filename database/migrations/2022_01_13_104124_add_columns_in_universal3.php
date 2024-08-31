<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUniversal3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal3', function (Blueprint $table) {
            $table->string('reg_no')->nullable();
            $table->string('reg_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universal3', function (Blueprint $table) {
            $table->dropColumn('reg_no');
            $table->dropColumn('reg_date');
        });
    }
}
