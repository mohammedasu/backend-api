<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectedContentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protected_content_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('protected_content_id');
            $table->foreign('protected_content_id')->references('id')->on('protected_contents');
            $table->enum('member_type',['members','universal','telecaller_members']);
            $table->string('member_id');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('logged_in')->default(false);
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
        Schema::dropIfExists('protected_content_users');
    }
}
