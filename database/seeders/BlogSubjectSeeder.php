<?php

namespace Database\Seeders;

use App\Models\BlogSubject;
use App\Models\Enums\Department;
use App\Models\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BlogSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogSubject::create([
            'name' => 'admin',
            'parent_id' => null,
            'category_id' => null,
        ]);
        User::factory()->count(20)->create();
    }
}
