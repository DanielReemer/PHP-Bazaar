<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\functional\PostStatusSeeder;
use Database\Seeders\functional\RolesTableSeeder;
use Database\Seeders\test\AdvertReviewSeeder;
use Database\Seeders\test\AdvertSeeder;
use Database\Seeders\test\LandingPageSeeder;
use Database\Seeders\test\UserReviewSeeder;
use Database\Seeders\test\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call functionality seeders
        $this->call([
            PostStatusSeeder::class,
            RolesTableSeeder::class,
        ]);

        // Call testdata seeders
        $this->call([
            UserSeeder::class,
            LandingPageSeeder::class,
            UserReviewSeeder::class,
            AdvertSeeder::class,
            AdvertReviewSeeder::class,
        ]);
    }
}
