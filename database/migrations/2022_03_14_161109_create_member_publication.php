<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPublication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_publication', function (Blueprint $table) {
            $table->id();
            $table->string('member_publication_ref_no');
            $table->unsignedInteger('member_id');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->longText('summery')->nullable();
            $table->date('published_on')->nullable();
            $table->foreign('member_id')->references('id')->on('members');
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
        Schema::dropIfExists('member_publication');
    }
}
