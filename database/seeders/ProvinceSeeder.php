<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/provinces.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          Province::create(array(
            'province_id' => $obj->code,
            'name' => $obj->name
          ));
        }
    }
}
