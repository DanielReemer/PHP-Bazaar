<?php

namespace Database\Factories;

use App\Models\UserReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserReviewFactory extends Factory
{
    protected $model = UserReview::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'comment' => $this->faker->paragraph(2),
        ];
    }
}
