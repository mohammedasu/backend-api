<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMciDocumentsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mci_documents_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members');
            $table->json('mci_document')->nullable();
            $table->tinyInteger('is_documents_verified')->default(0);
            $table->tinyInteger('no_document')->default(0);
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
        Schema::dropIfExists('mci_documents_details');
    }
}
