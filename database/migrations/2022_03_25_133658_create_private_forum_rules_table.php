<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateForumRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_forum_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('rule_type',['password', 'approval','invitation'])->nullable(false);
            $table->string('rule_action')->nullable();
            $table->unsignedInteger('forum_id');
            $table->foreign('forum_id')->references('id')->on('partner_divisions');
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
        Schema::dropIfExists('private_forum_rules');
    }
}
