<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link_id')->nullable(false)->unique();
            $table->string('title')->nullable(false);
            $table->longText('description')->nullable(true);
            $table->unsignedInteger('expert_id');
            $table->foreign('expert_id')->references('id')->on('experts');
            $table->unsignedInteger('community_id');
            $table->foreign('community_id')->references('id')->on('communities');
            $table->unsignedInteger('partner_division_id')->nullable();
            $table->foreign('partner_division_id')->references('id')->on('partner_divisions');
            $table->boolean('is_active')->default(true);
            $table->enum('question_type', ['mcq', 'comments'])->default('mcq');
            $table->integer('views')->default(0);
            $table->ipAddress('ip_address');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropForeign(['partner_division_id']);
            $table->dropForeign(['community_id']);
            $table->dropForeign(['expert_id']);
        });
        Schema::dropIfExists('cases');
    }
}
