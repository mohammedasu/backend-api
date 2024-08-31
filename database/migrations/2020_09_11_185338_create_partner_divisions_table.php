<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id');
            $table->string('image_name')->nullable(true);
            $table->string('name', 200)->nullable(false);
            $table->boolean('is_active')->default(1);
            $table->ipAddress('ip_address')->nullable(true)->default(null);
            $table->string('link_name')->default(null);
            $table->softDeletes();
            $table->foreign('partner_id')->references('id')->on('partners');
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
        Schema::table('partner_divisions', function (Blueprint $table) {
            // $table->dropForeign(['partner_id']);
        });
        Schema::dropIfExists('partner_divisions');
    }
}
