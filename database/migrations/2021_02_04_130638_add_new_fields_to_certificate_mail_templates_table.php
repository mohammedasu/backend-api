<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCertificateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificate_mail_templates', function (Blueprint $table) {
            $table->boolean('button_enabled')->default(true);
            $table->string('button_text')->default('Watch Video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate_mail_templates', function (Blueprint $table) {
            // $table->dropColumn('button_enabled');
            // $table->dropColumn('button_text');
        });
    }
}
