<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowForTelecallerAdminInWhatsappTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->boolean('show_in_telecaller_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->dropColumn('show_in_telecaller_admin');
        });
    }
}
