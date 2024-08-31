<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname', 10);
            $table->string('lname', 10);
            $table->string("mobile_number",20)->nullable(false);
            $table->string('email',50)->nullable(false);
            $table->string('pwd', 255)->nullable(false);

            $table->string('profile_image')->nullable(true)->default(null);

            $table->date('dob')->nullable(true)->default(null);

            $table->string('qualification', 200)->nullable(true)->default(null);
            $table->string('rno', 50)->nullable(true)->default(null);
            $table->year('registered_year')->nullable(true)->default(null);

            $table->string('state', 50)->nullable(true)->default(null);
            $table->string('city', 50)->nullable(true)->default(null);

            $table->longText('communities')->nullable(true)->default(null);
            $table->longText('associations')->nullable(true)->default(null);

            $table->string('register_type',50)->default('Medisage');
            $table->boolean('agree')->default(1);

            $table->ipAddress('ip_address')->nullable(true)->default(null);

            $table->softDeletes();

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
        Schema::dropIfExists('members');
    }
}
