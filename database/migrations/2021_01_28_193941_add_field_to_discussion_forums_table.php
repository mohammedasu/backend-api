<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToDiscussionForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussion_forms', function (Blueprint $table) {
            $table->string('temp_url')->nullable();
            $table->boolean('approved')->default(false);
        });
        Schema::table('discussion_form_details', function (Blueprint $table) {
            $table->string('temp_url')->nullable();
            $table->boolean('approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discussion_forms', function (Blueprint $table) {
            $table->dropColumn('temp_url');
            $table->dropColumn('approved');
        });
        Schema::table('discussion_form_details', function (Blueprint $table) {
            $table->dropColumn('temp_url');
            $table->dropColumn('approved');
        });
    }
}
