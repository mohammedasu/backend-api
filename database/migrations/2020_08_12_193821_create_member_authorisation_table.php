<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAuthorisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_authorisation', function (Blueprint $table) {

            $table->increments('id');

            $table->string('token', 255)->nullable(false);

            $table->boolean('is_active')->default(true);

            $table->dateTime('session_start_time')->default(NOW());

            $table->dateTime('last_visited_at')->default(NOW())->nullable();

            $table->dateTime('session_ended_at')->nullable(true)->default(null);

            $table->ipAddress('ip_address')->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_authorisation');
    }
}
