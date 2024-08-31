<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversalMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal_members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('mobile_number')->index('mobile_number')->nullable(false);
            $table->integer('mobile_number_length')->default(0);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(true);
            $table->string('speciality')->nullable(true);
            $table->string('updated_speciality')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('reg_state')->nullable(true);
            $table->string('metro_type')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('tier')->nullable(true);
            $table->string('country_code')->nullable(true);
            $table->string('zone')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('data_source')->nullable(true);
            $table->string('rno')->nullable(true);
            $table->string('registered_year')->nullable(true);
            $table->string('dob')->nullable(true);
            $table->string('qualification')->nullable(true);
            $table->boolean('sms_delivered')->nullable(true);
            $table->boolean('need_to_validate_number')->default(false)
                ->comment('Need to Validate Mobile Number (Zero SMS Delivered)');

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
        Schema::dropIfExists('universal_members');
    }
}
