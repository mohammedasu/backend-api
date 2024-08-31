<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Country;

class CountryTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country_list = json_decode(Storage::disk('local')->get('public/country_master.json'), true)['Data'];
        foreach ($country_list as $val) {
            Country::create([
                "sortname" => $val['sortname'],
                "name" => $val['name'],
                "phonecode" => $val['phonecode'],
            ]);
        }
    }
}
