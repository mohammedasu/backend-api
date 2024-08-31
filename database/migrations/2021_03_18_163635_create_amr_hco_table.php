<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmrHcoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amr_hco', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('amr_page_id')->nullable();

            $table->foreign('amr_page_id')->references('id')->on('amr_pages');

            $table->string('registration_image')->nullable();

            $table->string('email_image')->nullable();

            $table->string('banner_image')->nullable();

            $table->string('pwd', 255)->nullable(false);

            $table->string('hco_link_id')->nullable();

            $table->boolean('is_active')->default(1);

            $table->ipAddress('ip_address')->nullable(false);

            $table->integer('show_survey_at')->nullable(false)->comment("Percentage at which the survey has to be shown");

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
        Schema::dropIfExists('amr_hco');
    }
}
