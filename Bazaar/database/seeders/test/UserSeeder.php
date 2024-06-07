<?php

namespace Database\Seeders\test;

use App\Models\User;
use Illuminate\Database\Seeder;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(9)->create();

        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@test.com',
            'password' => 'password',
            'is_admin' => true,
            'role_id' => 3, // 3 = Roles.BusinessAdvertiser
            'remember_token' => Str::random(10),
            'api_key' => bin2hex(random_bytes(30)),
        ]);
    }
}
