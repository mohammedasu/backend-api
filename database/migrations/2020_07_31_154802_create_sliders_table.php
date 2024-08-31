<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->nullable(false);
            $table->string('image')->nullable(false);
            $table->string('description', 200)->nullable(true);
            $table->string('link', 200)->nullable(true);
            $table->string('button_name', 50)->nullable(true);
            $table->ipAddress('ip_address');

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('sliders');
    }
}
