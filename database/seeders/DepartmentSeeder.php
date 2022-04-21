<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name' => 'HCNS']);
        Department::create(['name' => 'HB01']);
        Department::create(['name' => 'HB02']);
        Department::create(['name' => 'HB03']);
        Department::create(['name' => 'HB04']);
        Department::create(['name' => 'HBF']);
    }
}
