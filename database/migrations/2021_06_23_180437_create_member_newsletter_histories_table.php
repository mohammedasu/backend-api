<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberNewsletterHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_newsletter_histories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');

            $table->unsignedInteger('newsletter_id')->nullable();
            $table->foreign('newsletter_id')->references('id')->on('newsletters');

            $table->enum('source', ['app','website'])->default('website');

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
        Schema::dropIfExists('member_newsletter_histories');
    }
}
