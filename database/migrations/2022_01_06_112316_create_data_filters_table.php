<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_filters', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable(false);

            $table->text('description')->nullable(true);

            $table->json('universal_filters')->nullable(true);
            $table->json('member_filters')->nullable(true);
            $table->json('live_event_filters')->nullable(true);

            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('created_by')->nullable(false);

            $table->integer('data_count')->default(0)->nullable(true);

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
        Schema::dropIfExists('data_filters');
    }
}
