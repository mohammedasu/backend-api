<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_endpoints', function (Blueprint $table) {
            $table->increments('id');

            $table->text('url')->nullable(false);
            $table->string('user_name', 200)->nullable(false);
            $table->string('password', 200)->nullable(false);

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
        Schema::dropIfExists('email_endpoints');
    }
}
