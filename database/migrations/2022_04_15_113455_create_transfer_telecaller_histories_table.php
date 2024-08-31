<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferTelecallerHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_telecaller_histories', function (Blueprint $table) {
            $table->id();
            $table->string('project')->nullable();
            $table->integer('count_transfered')->default(0);
            $table->boolean('processed')->nullable();
            $table->string('log_file')->nullable();
            $table->json('to_telecallers')->nullable();
            $table->unsignedInteger('from_telecaller')->nullable();
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
        Schema::dropIfExists('transfer_telecaller_histories');
    }
}
