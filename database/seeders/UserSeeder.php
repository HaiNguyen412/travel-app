<?php

namespace Database\Seeders;

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
            'first_name' => 'Nguyen Van',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => '123321abc',
            'status' => 1,
//            'role_id' => Role::IT_ADMIN,
            'remember_token' => Str::random(10),
        ]);
        User::factory()->count(20)->create();
    }
}
