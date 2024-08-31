<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeCategoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge_category_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('knowledge_category_id')->nullable();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories');
            $table->string('type')->nullable(false);
            $table->unsignedInteger('type_id')->nullable(false);
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
        Schema::table('knowledge_category_items', function (Blueprint $table) {
            $table->dropForeign(['knowledge_category_id']);
        });
        Schema::dropIfExists('knowledge_category_items');
    }
}
