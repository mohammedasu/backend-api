<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberContentSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_content_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('member_type');
            $table->string('member_id');
            $table->string('subscription_id');
            $table->boolean('status');
            $table->json('data');
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
        Schema::dropIfExists('member_content_subscriptions');
    }
}
