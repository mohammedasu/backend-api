<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterExpert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->unsignedInteger('knowledge_category_id')->nullable();
            $table->foreign('knowledge_category_id')->references('id')->on('knowledge_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->dropForeign(['knowledge_category_id']);
            $table->dropColumn(['knowledge_category_id']);
        });
    }
}
