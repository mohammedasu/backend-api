<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestPageResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_page_responses', function (Blueprint $table) {
            $table->id();

            $table->string('state')->nullable(false);
            $table->string('speciality')->nullable(true);
            $table->ipAddress('ip_address')->nullable(false);

            $table->unsignedInteger('interest_page_id')->nullable();
            $table->foreign('interest_page_id')->references('id')->on('interest_page');

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
        Schema::dropIfExists('interest_page_responses');
    }
}
