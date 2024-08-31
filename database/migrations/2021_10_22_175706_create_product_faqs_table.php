<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->longText('answer')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('whatsapp_template_id')->nullable();
            $table->unsignedBigInteger('email_template_id')->nullable();
            $table->unsignedBigInteger('sms_template_id')->nullable();
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
        Schema::dropIfExists('product_faqs');
    }
}
