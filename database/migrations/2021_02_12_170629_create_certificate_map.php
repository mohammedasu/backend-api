<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_map', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('certificate_id')->nullable();
            $table->foreign('certificate_id')->references('id')->on('certificates');

            $table->enum('type', ['live_event'])->default('live_event');

            $table->string("type_id")->nullable(true);

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
        Schema::dropIfExists('certificate_map');
    }
}
