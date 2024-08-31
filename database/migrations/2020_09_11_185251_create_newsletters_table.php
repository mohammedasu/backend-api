<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewslettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200)->nullable(false);
            $table->unsignedInteger('partner_id');
            $table->string('image_name')->nullable(true);
            $table->string('preview')->nullable(true);
            $table->string('file_name', 200)->nullable(false);
            $table->string('description', 500)->nullable(true);
            $table->boolean('is_active')->default(true);
            $table->ipAddress('ip_address')->nullable(true)->default(null);
            $table->foreign('partner_id')->references('id')->on('partners');
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
        Schema::table('newsletters', function (Blueprint $table) {
            $table->dropForeign(['partner_id']);
        });
        Schema::dropIfExists('newsletters');
    }
}
