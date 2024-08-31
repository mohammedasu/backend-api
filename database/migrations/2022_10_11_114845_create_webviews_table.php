<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webviews', function (Blueprint $table) {
            $table->id();
            $table->string('webview_key');
            $table->string('webview_url');
            $table->string('which_page')->nullable();
            $table->string('image')->nullable();
            $table->boolean('show_in_slider')->default(false);
            $table->boolean('replace_page')->default(false);
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
        Schema::dropIfExists('webviews');
    }
}
