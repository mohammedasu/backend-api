<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAffiliation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sites')->insert([
            'title' => 'INDIAN EPILEPSY SOCIETY',
            'logo_image' => '_IEYS.jpg',
            'banner_image' => ' ',
            'description' => ' ',
            'about' => ' ',
            'vision' => ' ',
            'mission' =>  ' ',
            'reg_address' => ' ',
            'founded_year' => ' ',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
