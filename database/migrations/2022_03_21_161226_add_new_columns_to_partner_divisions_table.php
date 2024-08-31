<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToPartnerDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_divisions', function (Blueprint $table) {
            //
            $table->dropForeign(['partner_id']);
            $table->string('forum_type')->nullable()->default('partner');
            $table->enum('geographic_type', ['country', 'state', 'city'])->nullable(true);
            $table->json('country')->nullable(true);
            $table->json('state')->nullable(true);
            $table->json('city')->nullable(true);
            $table->json('user_types')->nullable(true);
            $table->longText('cta_data')->nullable(true);
            $table->tinyInteger('show_followers')->default(0);
            $table->string('forum_council_expert_text')->nullable();
            $table->string('forum_other_expert_text')->nullable();
            $table->json('forum_manager')->nullable(true);
            $table->enum('forum_visibility', ['public', 'private'])->default('public')->nullable(true);
            $table->unsignedInteger('created_by')->nullable();
            $table->enum('created_from', ['admin', 'user'])->nullable();
            $table->unsignedInteger('partner_id')->nullable(true)->change();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->string('link_name')->unique()->change();
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
            $table->dropForeign(['partner_id']);
            $table->dropUnique(['link_name']);
            $table->dropColumn(['forum_type', 'geographic_type', 'country', 'state', 'city', 'cta_data', 'show_followers', 'user_types', 'forum_manager', 'forum_visibility', 'forum_council_expert_text', 'forum_other_expert_text', 'created_by', 'created_from']);
        });
    }
}
