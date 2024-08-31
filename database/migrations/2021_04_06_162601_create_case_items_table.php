<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('image_name')->nullable(false);

            $table->unsignedInteger('case_id');
            $table->foreign('case_id')->references('id')->on('cases');

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
        Schema::dropIfExists('case_items');
    }
}
