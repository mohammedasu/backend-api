<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('display_name', 50);
            $table->unsignedInteger('community_id')->nullable();
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
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
        Schema::table('knowledge_categories', function (Blueprint $table) {
            $table->dropForeign(['community_id']);
        });
        Schema::dropIfExists('knowledge_categories');
    }
}
