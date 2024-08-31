<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0);
            $table->string('currency')->default('INR');
            $table->string('content_type')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
            $table->timestamp('validity')->nullable();
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
        Schema::dropIfExists('content_subscriptions');
    }
}
