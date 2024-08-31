<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappInternalTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_internal_templates', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('whatsapp_template_id')->nullable();
            $table->foreign('whatsapp_template_id')->references('id')->on('whatsapp_templates');

            $table->string('name')->nullable(false);

            $table->text('content')->nullable(false);

            $table->boolean('intermediate_status_template')->default(true);

            $table->boolean('final_status_template')->default(true);

            $table->string('additional_info')->nullable(true);

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
        Schema::dropIfExists('whatsapp_internal_templates');
    }
}
