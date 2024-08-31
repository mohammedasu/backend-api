<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCmeMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cme_maps', function (Blueprint $table) {
            $table->string('map_type')->change()->nullable();
            $table->renameColumn('map_id','map_type_id')->change();
            $table->integer('when_to_show')->after('map_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cme_maps', function (Blueprint $table) {
            $table->integer('map_type')->change()->nullable();
            $table->renameColumn('map_type_id','map_id')->change();
            $table->dropColumn('when_to_show');
        });
    }
}
