<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/districts.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
          District::create(array(
            'district_id' => $obj->code,
            'name' => $obj->name
          ));
        }
    }
}
