<?php

namespace Database\Seeders\test;

use App\Models\Advert;
use App\Models\AdvertReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdvertReviewSeeder extends Seeder
{
    public function run(): void
    {
        $adverts = Advert::all();
        $users = User::all();

        foreach ($adverts as $advert) {
            $amountOfReviews = rand(0, 4);

            for($i = 0; $i < $amountOfReviews; $i++) {
                $randomUserId = rand(1, count($users));

                AdvertReview::factory()->create([
                    'advert_id' => $advert->id,
                    'user_id' => $randomUserId,
                ]);
            }
        }
    }
}
