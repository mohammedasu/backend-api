<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('telecaller_id')->unsigned();
            $table->date("date");
            $table->time("time");
            $table->enum("status", ["check_in", "check_out"]);
            $table->timestamps();
            $table->foreign('telecaller_id')->references('id')->on('telecallers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telecaller_attendance');
    }
}
