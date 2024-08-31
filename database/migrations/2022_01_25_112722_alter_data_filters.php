<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDataFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_filters', function (Blueprint $table) {

            $table->string('download_file_name')->nullable(true);
            $table->timestamp('download_processed_at')->nullable(true);

            $table->boolean('is_active')->default(false)->change();
            $table->renameColumn('is_active','download_in_process');


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
            $table->dropColumn('download_file_name');
            $table->dropColumn('download_processed_at');
            $table->renameColumn('download_in_process','is_active');
        });

    }
}
