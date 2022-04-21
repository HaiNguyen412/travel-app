<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Group 1', 'created_by' => 1, 'assignee' => 2]);
        Category::create(['name' => 'Group 2', 'created_by' => 1, 'assignee' => 3]);
        Category::create(['name' => 'Group 3', 'created_by' => 2, 'assignee' => 2]);
        Category::create(['name' => 'Group 4', 'created_by' => 2, 'assignee' => 4]);
    }
}
