<?php

namespace Database\Seeders\test;

use App\Models\User;
use App\Models\UserReview;
use Illuminate\Database\Seeder;

class UserReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $amountOfReviews = rand(0, 4);

            for($i = 0; $i < $amountOfReviews; $i++) {
                $randomUserId = rand(1, count($users));

                UserReview::factory()->create([
                    'user_id' => $user->id,
                    'reviewer_id' => $randomUserId,
                ]);
            }
        }
    }
}
