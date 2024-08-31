<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('community_id');

            $table->string('card_image')->nullable();

            $table->string('card_name')->nullable(false);

            $table->string('header')->nullable(false);

            $table->string('journal')->nullable(true);

            $table->text('small_description')->nullable(false);

            $table->mediumText('content')->nullable(false);

            $table->foreign('community_id')->references('id')->on('communities');

            $table->boolean('is_active')->default(true);

            $table->ipAddress('ip_address');

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
        Schema::dropIfExists('articles');
    }
}
