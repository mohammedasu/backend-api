<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberVerifybyWhoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_verifyby_who', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_to_verify',250);
            $table->unsignedInteger('member_id')->nullable();
            $table->boolean('verified_status')->default(false);
            $table->string('verified_by',200);
            $table->unsignedInteger('verified_by_id')->nullable();
            $table->boolean('mci_user_status')->default(false);
            $table->boolean('mci_reg_status')->default(false);
            $table->boolean('mci_state_status')->default(false);
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
        Schema::dropIfExists('member_verifyby_who');
    }
}
