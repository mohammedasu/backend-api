<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_contents', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('endpoint_id')->nullable();

            $table->string('email_type', 50)->nullable(false);

            $table->string('from', 50)->nullable(false);

            $table->string('replyTo', 50)->nullable(true);

            $table->longText('subject')->nullable(false);

            $table->longText('content')->nullable(false);

            $table->string('placeholders', 50)->nullable(true)->default(null);

            $table->ipAddress('ip_address');

            $table->foreign('endpoint_id')->references('id')->on('email_endpoints');

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
        Schema::dropIfExists('email_contents');
    }
}
