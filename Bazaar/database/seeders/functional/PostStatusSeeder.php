<?php

namespace Database\Seeders\functional;

use App\Models\PostStatus;
use Illuminate\Database\Seeder;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                "name" => 'available',
                'translation_key'=> 'postStatus.available',
            ],
            [
                "name" => 'expired',
                'translation_key'=> 'postStatus.expired',
            ],
            [
                "name" => 'rented',
                'translation_key'=> 'postStatus.rented',
            ],
            [
                "name" => 'sold',
                'translation_key'=> 'postStatus.sold',
            ],
        ];

        foreach ($statuses as $status) {
            PostStatus::create([
                'name' => $status['name'],
                'translation_key' => $status['translation_key']
            ]);
        }
    }
}
