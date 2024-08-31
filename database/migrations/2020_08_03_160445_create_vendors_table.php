<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable(false);
            $table->string('email',50)->nullable();
            $table->string('address',500)->nullable();
            $table->integer("mobile_number")->nullable();
            $table->boolean('is_active')->default(true);

            $table->string('contact_person_name')->nullable(false);

            $table->softDeletes();
            $table->ipAddress('ip_address');
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
        Schema::dropIfExists('vendors');
    }
}
