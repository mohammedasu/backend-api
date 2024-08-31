<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_links', function (Blueprint $table) {
            $table->increments('id');

            $table->string("link_name")->nullable(false);

            $table->string('image_name')->nullable(true);

            $table->string('video_id')->nullable(true);

            $table->string('landing_url')->nullable(true);

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
        Schema::dropIfExists('marketing_links');
    }
}
