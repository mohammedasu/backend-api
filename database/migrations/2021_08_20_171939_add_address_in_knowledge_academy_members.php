<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressInKnowledgeAcademyMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('knowledge_academy_members', function (Blueprint $table) {
            $table->string('address')->nullable(true);
            $table->integer('pin_code')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('knowledge_academy_members', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('pin_code');
        });
    }
}
