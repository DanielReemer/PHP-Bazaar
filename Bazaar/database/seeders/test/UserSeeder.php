<?php

namespace Database\Seeders\test;

use App\Models\LandingPage;
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
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@test.com',
            'password' => 'password',
            'is_admin' => true,
            'role_id' => 3, // 3 = Roles.BusinessAdvertiser
            'remember_token' => Str::random(10),
        ]);

        User::factory()->count(9)->create();

        $users = User::all();

        foreach ($users as $user) {
            if($user->role_id == 3) {
                $landing_page = LandingPage::create();
                $user->landing_page_id = $landing_page->id;
                $user->save();
            }
        }
    }
}
