<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexInUniversal3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('universal3', function (Blueprint $table) {
            $table->index('first_name');
            $table->index('last_name');
            $table->index('email');
            $table->index('city');
            $table->index('speciality');
            $table->index('state');
            $table->index('reg_no');
            $table->index('reg_state');
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
            $table->dropIndex(['first_name']);
            $table->dropIndex(['last_name']);
            $table->dropIndex(['email']);
            $table->dropIndex(['city']);
            $table->dropIndex(['speciality']);
            $table->dropIndex(['state']);
            $table->dropIndex(['reg_no']);
            $table->dropIndex(['reg_state']);
        });
    }
}
