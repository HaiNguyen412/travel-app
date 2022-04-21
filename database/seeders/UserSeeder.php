<?php

namespace Database\Seeders;

use App\Models\Enums\Department;
use App\Models\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '123123123',
            'code_login' => Str::random(5),
            'status' => 1,
            'google_token' => '',
            'role_id' => Role::IT_ADMIN,
            'department_id' => Department::HCNS,
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Do Khanh Trung',
            'email' => 'trung@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '123123123',
            'code_login' => Str::random(5),
            'status' => 1,
            'role_id' => Role::IT_ADMIN,
            'department_id' => Department::HCNS,
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Do Quang Vinh',
            'email' => 'vinh@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '123123123',
            'code_login' => Str::random(5),
            'status' => 1,
            'role_id' => Role::IT_ADMIN,
            'department_id' => Department::HCNS,
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Nguyen Duyen Manh',
            'email' => 'manh@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '123123123',
            'code_login' => Str::random(5),
            'status' => 1,
            'role_id' => Role::IT_ADMIN,
            'department_id' => Department::HCNS,
            'remember_token' => Str::random(10),
        ]);
        User::factory()->count(20)->create();
    }
}
