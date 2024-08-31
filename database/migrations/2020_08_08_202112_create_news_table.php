<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('title');
            $table->unsignedInteger('community_id')->nullable();

            $table->longText('description')->default(null);

            $table->string('meta_title', 200)->nullable(true);

            $table->string('rss_id', 50)->nullable(true);

            $table->string('meta_description', 500)->nullable(true);
            $table->string('meta_keywords')->nullable(true);

            $table->boolean('is_active')->default(true);

            $table->ipAddress('ip_address');
            $table->softDeletes();
            $table->foreign('community_id')->references('id')->on('communities');

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
        Schema::dropIfExists('news');
    }
}
