<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->nullable(false);
            $table->string('logo_image')->nullable(true);
            $table->string('description', 500)->nullable(true);
            $table->string('meta_title', 200)->nullable(true);
            $table->string('meta_description', 500)->nullable(true);
            $table->string('meta_keywords')->nullable(true);
            $table->boolean('is_active')->default(true);
            $table->string('link_name')->default(null);
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
        Schema::dropIfExists('partners');
    }
}
