<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->unsignedInteger('link_id');

            $table->string('country_code', 10)->default("+91");
            $table->string('mobile_number',20)->nullable(false);
            $table->string('email',50)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('pwd', 15)->nullable();

            $table->string('state', 255)->default(null);

            $table->unsignedInteger('community_id')->default(null);

            $table->boolean('visited_during_session')->default(0);

            $table->ipAddress('ip_address');

            $table->softDeletes();

            $table->timestamps();

            $table->unique(['link_id','country_code','mobile_number']);
            $table->foreign('link_id')->references('id')->on('live_events');
            $table->foreign('community_id')->references('id')->on('communities');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_event_members');
    }
}
