<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignTelecallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_telecallers', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->string('title');
            $table->string('file_name');
            $table->timestamp('schedule_time');
            $table->unsignedInteger('project_id');
            $table->boolean('processed')->nullable();
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
        Schema::dropIfExists('assign_telecallers');
    }
}
