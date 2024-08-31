<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInLiveEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->boolean('show_header_footer')->default(true);
            $table->boolean('send_sms')->default(true);
            $table->boolean('send_whatsapp')->default(true);
            $table->boolean('send_email')->default(true);
            $table->boolean('show_in_app')->default(true);
            $table->string('password')->nullable(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_events', function (Blueprint $table) {
            $table->dropColumn('show_header_footer');
            $table->dropColumn('send_sms');
            $table->dropColumn('send_whatsapp');
            $table->dropColumn('send_email');
            $table->dropColumn('show_in_app');
            $table->dropColumn('password');

        });
    }
}
