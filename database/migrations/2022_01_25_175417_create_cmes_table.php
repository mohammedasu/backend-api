<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->enum('result_type', ['percentage', 'points'])->nullable();
            $table->integer('points')->nullable();
            $table->longText('result_content')->nullable();
            $table->integer('passing_criteria')->nullable();
            $table->boolean('show_result')->default('0');
            $table->boolean('show_landing_page')->default('0');
            $table->boolean('has_certificate')->default('0');
            $table->boolean('allow_back')->default('0');
            $table->boolean('allow_retest')->default('0');
            $table->boolean('status')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cmes');
    }
}
