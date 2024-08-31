<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskexpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('askexperts', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable(false)->unique();
            $table->string('case_history')->nullable(false);
            $table->longText('presenting_complaints')->nullable(false);
            $table->longText('question')->nullable(false);
            $table->json('images')->nullable();
            $table->unsignedInteger('expert_id');
            $table->foreign('expert_id')->references('id')->on('experts');
            $table->unsignedInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedInteger('map_id')->nullable(false);
            $table->string('map_type')->default('forum');
            $table->boolean('is_active')->default(false);
            $table->enum('case_status', ['under_review', 'sent_to_expert', 'respond_to_user', 'publish'])->default('under_review');
            $table->integer('views')->default(0);
            $table->integer('view_multiplication_factor')->default(0);
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
        Schema::table('askexperts', function (Blueprint $table) {
            $table->dropForeign(['expert_id']);
            $table->dropForeign(['member_id']);
        });
        Schema::dropIfExists('askexperts');
    }
}
