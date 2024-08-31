<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('community_id');
            $table->string('name');

            $table->string('image_name')->nullable();
            $table->string('designation')->nullable(true);

            $table->string('working_at')->nullable();
            $table->longText('areas_of_interest')->nullable();

            $table->longText('description')->nullable(true);
            $table->string('thumbnail_url')->nullable();

            //todo add the following video_link video_image

            $table->foreign('community_id')->references('id')->on('communities');

            $table->string('meta_title', 200)->nullable(true);
            $table->string('meta_description', 500)->nullable(true);
            $table->string('meta_keywords')->nullable(true);
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
        Schema::dropIfExists('experts');
    }
}
