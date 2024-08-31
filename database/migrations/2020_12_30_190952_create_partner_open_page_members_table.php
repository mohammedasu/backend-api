<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerOpenPageMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_open_page_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->string("mobile_number", 20)->nullable(false);
            $table->string('country', 50)->nullable(true)->default(null);
            $table->ipAddress('ip_address');
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
        Schema::table('partner_open_page_members', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
        });
        Schema::dropIfExists('partner_open_page_members');
    }
}
