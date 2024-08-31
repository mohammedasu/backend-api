<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeAcademyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_academy_members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email_id')->nullable(false);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(true);
            $table->string('mobile_number')->nullable(true);
            $table->unsignedInteger('partner_division_id');
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->boolean('interested_in_research_grant')->default(true);
            $table->boolean('interested_in_reaching_out')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_forum_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['partner_division_id']);
        });
        Schema::dropIfExists('knowledge_academy_members');
    }
}
