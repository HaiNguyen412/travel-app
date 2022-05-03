<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DistrictSeeder::class,
            // ProvinceSeeder::class,
            // CountrySeeder::class,
            // AreaSeeder::class,
            // RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
