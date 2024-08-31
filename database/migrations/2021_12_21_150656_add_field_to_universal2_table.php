<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUniversal2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('universal2', function (Blueprint $table) {
            $table->json('sub_speciality_list')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universal2', function (Blueprint $table) {
            $table->dropColumn('sub_speciality_list');
            $table->dropColumn('updated_by');
            $table->dropColumn('whatsapp_number');
        });
    }
}
