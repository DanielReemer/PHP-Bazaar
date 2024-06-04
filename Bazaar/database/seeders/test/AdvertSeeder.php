<?php

namespace Database\Seeders\test;

use App\Models\Advert;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdvertSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $amountOfAdverts = rand(0, 4);

            for($i = 0; $i < $amountOfAdverts; $i++) {
                Advert::factory()->create([
                    'owner_id' => $user->id,
                ]);
            }
        }
    }
}
