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
        $coutry = Country::query()->create([
            'name' => 'Seeking Tour Guide',
            'code' => 'seeking_tour_guide',
            'description' => $this->faker->realText(50),
        ]);
        
    }
}
