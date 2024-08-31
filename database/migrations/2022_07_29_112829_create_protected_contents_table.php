<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectedContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protected_contents', function (Blueprint $table) {
            $table->id();
            $table->string('content_id');
            $table->string('content_type');
            $table->string('default_username')->nullable();
            $table->string('default_password')->nullable();
            $table->boolean('use_different_passwords')->default(true);
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
        Schema::dropIfExists('protected_contents');
    }
}
