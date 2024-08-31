<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreeContentTypeInWhatsappTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->unique('template_id');
            $table->boolean('free_content_template')->default(false);
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
            $table->dropUnique(['template_id']);
            $table->dropColumn('free_content_template');
        });
    }
}
