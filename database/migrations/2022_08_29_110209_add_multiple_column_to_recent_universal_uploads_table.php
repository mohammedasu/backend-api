<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToRecentUniversalUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recent_universal_uploads', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
            $table->string('created_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recent_universal_uploads', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'created_from']);
        });
    }
}
