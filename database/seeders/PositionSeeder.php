<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create(['name' => 'Dev']);
        Position::create(['name' => 'Tester']);
        Position::create(['name' => 'BA']);
        Position::create(['name' => 'PM']);
        
    }
}
