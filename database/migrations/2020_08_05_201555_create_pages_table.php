<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image_name')->default(null);
            $table->longText('description')->default(null);

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
        Schema::dropIfExists('pages');
    }
}
