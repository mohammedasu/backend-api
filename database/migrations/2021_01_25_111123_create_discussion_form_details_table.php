<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_form_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discussion_id');
            $table->text('question')->nullable();
            $table->text('awnser')->nullable();
            $table->boolean('display_type')->default(false);
            $table->boolean('like')->default(false);
            $table->boolean('insightful')->default(false);
            $table->boolean('asked_to_expert')->default(false);
            $table->boolean('awnsered')->default(false);
            $table->unsignedBigInteger('expert_id')->nullable();
            $table->string('question_type')->default('public');
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
        Schema::dropIfExists('discussion_form_details');
    }
}
