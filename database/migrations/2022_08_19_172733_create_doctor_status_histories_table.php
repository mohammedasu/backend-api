<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_status_histories', function (Blueprint $table) {
            $table->id();
            $table->text('universal_member_ref_no');
            $table->enum("status", ["universal", "digiMR", "live_event", "member", "prime_user", "app_user", "unsubscribed"]);
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
        Schema::dropIfExists('doctor_status_histories');
    }
}


