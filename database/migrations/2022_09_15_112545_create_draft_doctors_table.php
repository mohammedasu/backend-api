<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("project_id");
            $table->unsignedInteger("telecaller_id");
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("email")->nullable();
            $table->string("mobile_number")->nullable();
            $table->string("alternate_number")->nullable();
            $table->string("whatsapp_number")->nullable();
            $table->enum('primary_type', ["mobile", "alternate", "whatsapp"])->default("mobile");
            $table->string("country");
            $table->string("state")->nullable();
            $table->string("city")->nullable();
            $table->text("address")->nullable();
            $table->enum('address_type', ["clinic", "residential"])->nullable();;
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->unsignedInteger("speciality_id")->nullable();
            $table->text("community_ids")->nullable();
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
        Schema::dropIfExists('draft_doctors');
    }
}
