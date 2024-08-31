<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInTelecallerMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {

            $table->renameColumn('new_mobile_number', 'whatsapp_number');
            $table->renameColumn('other_comments', 'best_time_to_call');

            $table->string('alternate_number')->nullable(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecaller_members', function (Blueprint $table) {
            $table->renameColumn('whatsapp_number','new_mobile_number');
            $table->renameColumn('best_time_to_call','other_comments');

            $table->dropColumn('alternate_number');
        });
    }
}
