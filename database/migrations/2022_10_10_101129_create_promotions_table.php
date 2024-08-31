<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ["app", "website"])->default('app');
            $table->string('which_page');
            $table->string('ad_type');
            $table->string('position');
            $table->json('images')->nullable();
            $table->json('image_action')->nullable();
            $table->json('valid_country')->nullable();
            $table->json('valid_communities')->nullable();
            $table->json('valid_member_types')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('created_by')->nullable();
            $table->string('created_from')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
