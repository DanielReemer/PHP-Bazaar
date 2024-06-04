<?php

namespace Database\Factories;

use App\Models\AdvertReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertReviewFactory extends Factory
{
    protected $model = AdvertReview::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'comment' => $this->faker->paragraph(2),
            'rating' => $this->faker->numberBetween(0, 5),
        ];
    }
}
