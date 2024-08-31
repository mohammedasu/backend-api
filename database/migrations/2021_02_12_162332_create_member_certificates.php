<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_certificates', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedInteger('certificate_id')->nullable();
            $table->foreign('certificate_id')->references('id')->on('certificates');

            $table->string('file_name')->nullable(false);

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
        Schema::dropIfExists('member_certificates');
    }
}
