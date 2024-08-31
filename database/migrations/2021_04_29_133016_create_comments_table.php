<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->text('comment')->nullable(false);

            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('comments');

            $table->string("reference_type")->nullable(false);
            $table->integer("reference_id")->nullable(false);

            $table->integer("comment_user_id")->nullable(false);
            $table->string("comment_user_type")->default('member');

            $table->boolean("is_approved")->default(true);

            $table->boolean("has_child")->default(false);

            $table->integer('likes')->default(0);

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
        Schema::dropIfExists('comments');
    }
}
