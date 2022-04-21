<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create(['area_id' => 1, 'name' => 'Area 1']);
        Area::create(['area_id' => 2, 'name' => 'Area 2']);
        Area::create(['area_id' => 3, 'name' => 'Area 3']);
        Area::create(['area_id' => 4, 'name' => 'Area 4']);

    }
}
