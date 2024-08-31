<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateForumInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('private_forum_invites', function (Blueprint $table) {
            $table->id();
            $table->string("mobile_number",20)->nullable(true);
            $table->string('email',100)->nullable(true);
            $table->bigInteger('private_forum_rule_id')->unsigned()->index();
            $table->foreign('private_forum_rule_id')->references('id')->on('private_forum_rules');
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
        Schema::dropIfExists('private_forum_invites');
    }
}
