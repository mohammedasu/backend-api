<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmediateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immediate_actions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('value')->nullable(true);
            $table->string('action')->nullable(true);
            $table->string('bg_color')->nullable(true);
            $table->string('action_id')->nullable(true);

            $table->unsignedInteger('created_by')->nullable(false);
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
        Schema::dropIfExists('immediate_actions');
    }
}
