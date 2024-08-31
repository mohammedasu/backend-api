<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKnowledgeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('knowledge_categories', function (Blueprint $table) {
            $table->longText('description')->nullable(true)->default(null);
            $table->boolean('is_active')->default(true);
            $table->string('banner_image')->nullable(true)->default(null);
            $table->string('logo_image')->nullable(true)->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
