<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmrMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amr_members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('fname', 10);
            $table->string('lname', 10);
            $table->string('email',50)->nullable(false);
            $table->string('speciality',50)->nullable(true);

            $table->string('country')->nullable(false);

            $table->unsignedInteger('amr_hco_id')->nullable();
            $table->foreign('amr_hco_id')->references('id')->on('amr_hco');

            $table->boolean('visited_during_session')->default(0);

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
        Schema::dropIfExists('amr_members');
    }
}
