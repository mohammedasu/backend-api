<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MemberForumSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_forum_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->unique(['member_id', 'partner_division_id']);
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
            $table->dropForeign(['member_id']);
            // $table->dropForeign(['partner_division_id']);
        });
        Schema::dropIfExists('member_forum_subscriptions');
    }
}
