<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_members', function (Blueprint $table) {
            $table->increments('id');

            //todo check if ->nullable(true) to be added

            $table->string('mobile_number')->index('mobile_number');
            $table->string('new_mobile_number')->nullable(true);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('speciality')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('reg_no')->nullable(true);
            $table->string('reg_state')->nullable(true);
            $table->integer('year_of_graduation')->nullable(true);

            $table->enum('primary_status',['OPEN', 'CLOSED', 'NEW'])->default('NEW');
            $table->enum('secondary_status',['CALL_BACK_LATER', 'NOT_INTERESTED', 'NO_RESPONSE', 'CALL_SUCCESSFUL', 'INVALID_PHONE_NUMBER','CALL_DONE_WITH_MORE_INFO_NEEDED'])->nullable(true);

            $table->text("notes")->nullable(true);
            $table->text("other_comments")->nullable(true);

            $table->timestamp('first_contact_time')->nullable(true);
            $table->timestamp('last_contact_time')->nullable(true);

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
        Schema::dropIfExists('telecaller_members');
    }
}
