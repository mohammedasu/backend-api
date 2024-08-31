<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToTelecallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecallers', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->boolean('is_field_mr')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecallers', function (Blueprint $table) {
            $table->dropColumn(['country', 'country_code', 'is_field_mr']);
        });
    }
}
