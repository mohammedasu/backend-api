<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorInDeliveryReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mtalks_delivery_report', function (Blueprint $table) {
            $table->string('vendor')->default('mtalkz');
        });
        Schema::table('mtalks_click_through_report', function (Blueprint $table) {
            $table->string('vendor')->default('mtalkz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mtalks_delivery_report', function (Blueprint $table) {
            $table->dropColumn('vendor');
        });
        Schema::table('mtalks_click_through_report', function (Blueprint $table) {
            $table->dropColumn('vendor');
        });
    }
}
