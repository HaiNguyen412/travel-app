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
            AreaSeeder::class,
            // RoleSeeder::class,
            // DepartmentSeeder::class,
            // PositionSeeder::class,
            // UserSeeder::class,
            // CategorySeeder::class,
            // PrioritySeeder::class,
            // RequestSeeder::class,
        ]);
    }
}
