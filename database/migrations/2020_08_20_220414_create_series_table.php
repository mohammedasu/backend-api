<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 500)->nullable();
            $table->string('image_name')->nullable();
            $table->longText('description')->nullable(true);
            $table->unsignedInteger('community_id')->nullable();
            $table->unsignedInteger('expert_id')->nullable();
            $table->unsignedInteger('partner_id')->nullable();
            $table->unsignedInteger('knowledge_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreign('community_id')->references('id')->on('communities');
            $table->foreign('expert_id')->references('id')->on('experts');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('knowledge_id')->references('id')->on('knowledge_categories');
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
        Schema::table('series', function (Blueprint $table) {
            // $table->dropForeign(['knowledge_id']);
            $table->dropForeign(['partner_id']);
            $table->dropForeign(['expert_id']);
            $table->dropForeign(['community_id']);
        });
        Schema::dropIfExists('series');
    }
}
