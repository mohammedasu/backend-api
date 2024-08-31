<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDataFilterDownloadInProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_filters', function (Blueprint $table) {
            $table->boolean('download_in_process')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_filters', function (Blueprint $table) {
            $table->boolean('download_in_process')->default(true)->change();
        });
    }
}
