<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtmMicrositesLinksDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utm_links_details', function (Blueprint $table) {
            $table->id();
            $table->integer('digimr_doctor_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('digimr_id')->nullable();
            $table->string('ref_id');
            $table->string('utm_medium')->default("whatsapp");
            $table->string('utm_campaign')->comment("like digimr_microsite_cases, digimr_microsite_videos digimr_forum, digimr_questions");
            $table->timestamps();
            $table->integer('utm_id');
            $table->text('utm_link');
            $table->integer('wave_number')->default(1);
            $table->integer('view_count')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utm_links_details');
    }
}
