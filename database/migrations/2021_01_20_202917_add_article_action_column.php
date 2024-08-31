<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleActionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_article_histories', function (Blueprint $table) {
            $table->string('action_type')->nullable(false)->default('read');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_article_histories', function (Blueprint $table) {
            $table->dropColumn('action_type');

        });
    }
}
