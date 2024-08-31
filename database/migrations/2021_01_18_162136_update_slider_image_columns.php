<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSliderImageColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->renameColumn('button_name', 'action_type');
            $table->renameColumn('link', 'action_id');

        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('action_id')->nullable(true)->change();
            $table->string('action_type')->nullable(true)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->renameColumn('action_type', 'button_name' );
            $table->renameColumn('action_id', 'link');
        });
    }
}
