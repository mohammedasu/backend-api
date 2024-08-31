<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMemberNewsletterHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_newsletter_histories', function (Blueprint $table) {
            $table->string('user_type')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_id')->nullable();
            $table->string('device_name')->nullable();
            $table->string('ip_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_newsletter_histories', function (Blueprint $table) {
            $table->dropColumn(['user_type','utm_source', 'utm_campaign', 'utm_medium', 'utm_id', 'device_name', 'ip_address']);
        });
    }
}
