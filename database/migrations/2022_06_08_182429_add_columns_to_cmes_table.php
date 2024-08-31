<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->integer('timer_status')->default(0);
            $table->integer('time_in_seconds')->default(0);
            $table->integer('negative_marks_status')->default(0);
            $table->integer('negative_mark')->nullable();
            $table->integer('positive_mark')->nullable();
            $table->string('survey_background_mobile_image')->nullable();
            $table->string('landing_page_image')->nullable();
            $table->string('landing_page_button_text')->nullable();
            $table->integer('registration_template_id')->nullable();
            $table->integer('coins')->default(0);
            $table->enum('coins_type',['coin','cash']);
            if (Schema::hasColumn('result_type', 'result_content','has_certificate')){
                $table->dropColumn(['result_type','result_content','has_certificate']);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cmes', function (Blueprint $table) {
            $table->dropColumn(['timer_status','time_in_seconds','negative_marks_status','negative_mark','positive_mark','survey_background_mobile_image','landing_page_image','landing_page_button_text','registration_template_id','coins','coins_type']);
        });
    }
}
