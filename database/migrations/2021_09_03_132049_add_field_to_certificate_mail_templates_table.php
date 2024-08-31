<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToCertificateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificate_mail_templates', function (Blueprint $table) {
            $table->json('attachments')->nullable();
            $table->boolean('template_type')->default(false);
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
            $table->dropColumn('attachments');
            $table->dropColumn('template_type');
        });
    }
}
