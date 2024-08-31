<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleFieldsToEngagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('engagements', function (Blueprint $table) {
            $table->renameColumn('type','notification_type');
            $table->integer('image_bank_id')->nullable();
            $table->string('action_type')->nullable();
            $table->string('action_id')->nullable();
            $table->string('device_type')->nullable();
            $table->longText('response')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::table('engagements', function (Blueprint $table) {
            $table->renameColumn('notification_type', 'type');
            $table->dropColumn(['image_bank_id','action_type','action_id','meta_title','meta_desc','meta_keywords','created_by','created_from']);
        });
    }
}
