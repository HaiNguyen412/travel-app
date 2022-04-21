<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create(['name' => 'Normal']);
        Priority::create(['name' => 'Urgent']);
        Priority::create(['name' => 'Very urgent']);
    }
}
