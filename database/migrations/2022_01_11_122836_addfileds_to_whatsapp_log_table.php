<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddfiledsToWhatsappLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_log', function (Blueprint $table) {
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('content_type')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
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
            $table->dropColumn('source_type');
            $table->dropColumn('source_id');
            $table->dropColumn('content_type');
            $table->dropColumn('content_id');
        });
    }
}
