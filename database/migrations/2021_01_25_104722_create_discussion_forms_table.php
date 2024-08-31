<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->json('reference_type')->nullable();
            $table->boolean('display_type')->default(false);
            $table->unsignedBigInteger('community_id')->nullable();
            $table->unsignedBigInteger('expert_id')->nullable();
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
        Schema::dropIfExists('discussion_forms');
    }
}
