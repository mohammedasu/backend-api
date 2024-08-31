
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelecallerMemberEngagementHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecaller_member_engagement_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('telecaller_member_id');
            $table->unsignedInteger('telecaller_id');
            $table->string('channel_type')->nullable();
            $table->string('channel_id');
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
        Schema::dropIfExists('telecaller_member_engagement_histories');
    }
}
