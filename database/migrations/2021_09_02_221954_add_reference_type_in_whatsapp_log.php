<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceTypeInWhatsappLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_log', function (Blueprint $table) {
            $table->string("reference_type")->nullable(true);
            $table->integer("reference_id")->nullable(true);

            $table->dropForeign(['member_id']);
            $table->dropForeign(['live_event_member_id']);

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
            $table->dropColumn('reference_type');
            $table->dropColumn('reference_id');
        });
    }
}
