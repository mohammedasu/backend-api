<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSendDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sent_mail_details', function (Blueprint $table) {
            $table->json('errors')->nullable();
            $table->integer('mail_cred_type')->nullable();
            $table->string('mail_type')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sent_mail_details', function (Blueprint $table) {
            $table->dropColumn('errors');
            $table->dropColumn('mail_cred_type');
        });
    }
}
