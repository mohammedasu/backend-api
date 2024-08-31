<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldNameInDiscussionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussion_forms', function (Blueprint $table) {
            $table->renameColumn('video_id','reference_id');
            $table->string('reference_type')->change();
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
            $table->renameColumn('reference_id','video_id');
            $table->json('reference_type')->nullable()->change();
        });
    }
}
