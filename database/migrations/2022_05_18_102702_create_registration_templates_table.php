<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->string('user_types');
            $table->longText('json_data');
            $table->integer('is_active')->default(1);
            $table->integer('created_by')->nullable();
            $table->string('created_from')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('registration_templates');
    }
}
