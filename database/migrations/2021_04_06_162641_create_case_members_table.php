<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_members', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('case_id');
            $table->foreign('case_id')->references('id')->on('cases');

            $table->unsignedInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');

            $table->boolean('useful')->nullable(true);

            $table->boolean('has_answered')->default(false);

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
        Schema::dropIfExists('case_members');
    }
}
