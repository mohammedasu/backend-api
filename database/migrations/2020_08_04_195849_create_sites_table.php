<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 500)->nullable(false);
            $table->string('logo_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('about')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->longText('objective')->nullable();
            $table->longText('contact_us')->nullable();
            $table->longText('reg_address')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('linkedIn_link')->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('is_active')->default(true);

            $table->ipAddress('ip_address')->nullable();
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
        Schema::dropIfExists('sites');
    }
}
