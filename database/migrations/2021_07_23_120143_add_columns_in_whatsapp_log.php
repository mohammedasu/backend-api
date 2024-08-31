<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInWhatsappLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_log', function (Blueprint $table) {
            $table->string('mid')->nullable(true);
            $table->json('notification_attributes')->nullable(true);
            $table->unsignedInteger('whatsapp_template_id')->nullable();
            $table->foreign('whatsapp_template_id')->references('id')->on('whatsapp_templates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whatsapp_log', function (Blueprint $table) {
            $table->dropColumn('mid');
            $table->dropColumn('notification_attributes');
            $table->dropForeign(['whatsapp_template_id']);
            $table->dropColumn('whatsapp_template_id');

        });
    }
}
