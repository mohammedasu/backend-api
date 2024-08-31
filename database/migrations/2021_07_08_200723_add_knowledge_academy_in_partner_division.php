<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKnowledgeAcademyInPartnerDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {

            $table->boolean('is_knowledge_academy_active')->default(false);
            $table->string('knowledge_academy_to_address')->nullable(true);
            $table->string('knowledge_academy_banner_image')->nullable(true);
            $table->text('interested_in_grant_text')->nullable(true);
            $table->text('reaching_out_text')->nullable(true);

            $table->text('external_link')->nullable(true);
            $table->string('knowledge_academy_name')->nullable(true);

            $table->string('knowledge_academy_header_text')->nullable(true);
            $table->string('knowledge_academy_thank_you_message')->nullable(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {

            $table->dropColumn('is_knowledge_academy_active');
            $table->dropColumn('knowledge_academy_to_address');
            $table->dropColumn('knowledge_academy_banner_image');
            $table->dropColumn('interested_in_grant_text');
            $table->dropColumn('reaching_out_text');
            $table->dropColumn('external_link');
            $table->dropColumn('knowledge_academy_name');
            $table->dropColumn('knowledge_academy_header_text');

        });
    }
}
