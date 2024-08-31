<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecallers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username', 50)->nullable(false);
            $table->string('password', 255)->nullable(false);

            $table->string('email',50)->nullable(false);

            //$table->string('type', 50)->nullable(true);

            $table->boolean('is_active')->default(true);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('telecallers');
    }
}
