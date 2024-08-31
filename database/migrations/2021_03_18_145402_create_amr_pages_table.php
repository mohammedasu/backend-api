<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAMRPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amr_pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable(false);

            $table->string('link_id', 50)->nullable(false);
            $table->string('video_id', 50)->nullable(false);
            $table->string('vchat_id', 50)->nullable(true);

            $table->string('country', 50)->nullable(true);

            $table->timestamp('event_timestamp')->nullable();

            $table->integer('buffer_time')->default(0)->comment("In minutes");

            $table->boolean('is_active')->default(1);

            $table->ipAddress('ip_address')->nullable(false);

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amr_pages');
    }
}
