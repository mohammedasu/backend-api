<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_configs', function (Blueprint $table) {
            $table->increments('id');

            $table->string("config_name")->nullable(false);
            $table->string("value")->nullable(false);

            $table->string("description")->nullable(true);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('common_configs');

    }
}
