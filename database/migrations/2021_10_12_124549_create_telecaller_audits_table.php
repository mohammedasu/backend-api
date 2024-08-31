<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_audits', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('telecaller_id')->nullable(true);
            $table->foreign('telecaller_id')->references('id')->on('telecallers');

            $table->text('event')->nullable(true);

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
        Schema::dropIfExists('telecaller_audits');
    }
}
