<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultValueArticleHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_article_histories', function (Blueprint $table) {
            $table->string('action_type')->nullable(false)->default('visited')->change();

        });
        DB::statement("update member_article_histories set action_type = 'visited' ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_article_histories', function (Blueprint $table) {
            $table->string('action_type')->nullable(false)->default('read')->change();
        });
    }
}
