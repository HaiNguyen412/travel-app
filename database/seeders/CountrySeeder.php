<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create(['country_id' => 84, 'name' => 'Viet Nam']);
        Country::create(['country_id' => 85, 'name' => 'Thai Lan']);
    }
}
