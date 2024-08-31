<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('college_name')->nullable(true);
            $table->string('year_of_passing')->nullable(true);
            $table->string('google_id_token')->nullable(true);
            $table->string('member_type')->nullable(true);
            $table->boolean('is_profile_complete')->default(true);

            $table->string('fname',100)->nullable(true)->change();
            $table->string('email',50)->nullable(true)->change();
            $table->string('mobile_number',20)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('college_name');
            $table->dropColumn('year_of_passing');
            $table->dropColumn('google_id_token');
            $table->dropColumn('member_type');
            $table->dropColumn('is_profile_complete');

            $table->string('fname',100)->nullable(false)->change();
            $table->string('email',50)->nullable(false)->change();
            $table->string('mobile_number',20)->nullable(false)->change();
        });
    }
}
