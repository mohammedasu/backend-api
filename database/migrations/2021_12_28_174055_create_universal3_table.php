<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversal3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal3', function (Blueprint $table) {
            $table->increments('id');

            $table->string('mobile_number')->index('mobile_number')->nullable(true)->index();
            $table->integer('mobile_number_length')->default(0);
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(true);
            $table->string('speciality')->nullable(true);
            $table->string('sub_speciality')->nullable(true);
            $table->string('reg_state')->nullable(true);
            $table->string('country_code')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('data_source')->nullable(true);
            $table->string('qualification')->nullable(true);

            $table->enum('is_whatsapp_active',['not attempted', 'not sent', 'failed', 'delivered', 'read', 'clicked', 'replied'])->nullable(true);
            $table->enum('sms_active',['not sent', 'delivered', 'clicked'])->nullable(true);

            $table->string('alternate_number')->nullable(true);
            $table->string('whatsapp_number')->nullable(true);

            $table->enum('user_status',['universal', 'digiMR', 'live_event', 'member', 'app_user', 'unsubscribed'])->nullable(true);
            $table->string('digiMR_status')->nullable(true);

            $table->string('city')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('zone')->nullable(true);
            $table->string('tier')->nullable(true);
            $table->string('metro')->nullable(true);
            $table->string('class')->nullable(true);

            $table->timestamp('member_since')->nullable(true)->default(now());
            $table->integer('articles_read')->nullable(true);

            $table->integer('cases_viewed')->nullable(true);
            $table->integer('live_events_registered')->nullable(true);
            $table->integer('newsletters_viewed')->nullable(true);
            $table->integer('videos_watched')->nullable(true);

            $table->timestamp('last_activity_date')->nullable(true);
            $table->integer('last_activity_id')->nullable(true);
            $table->string('last_activity_type')->nullable(true);
            $table->string('email_status')->nullable(true);

            $table->enum('last_activity_channel',['app','website'])->nullable(true);
            $table->enum('acquisition_source',['physiMR', 'digiMR', 'direct', 'social', 'affiliate', 'referral'])->nullable(true);

            $table->enum('email_active',['not sent', 'delivered', 'opened', 'clicked', 'replied'])->nullable(true);

            $table->integer('sms_score')->nullable(true);
            $table->integer('whatsapp_score')->nullable(true);
            $table->integer('email_score')->nullable(true);
            $table->integer('digiMR_score')->nullable(true);

            $table->string('reference_id')->nullable(true);

            $table->string('activation_channel')->nullable(true);

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
        Schema::dropIfExists('universal3');
    }
}

