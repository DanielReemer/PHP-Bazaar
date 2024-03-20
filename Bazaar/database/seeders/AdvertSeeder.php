<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advert;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        Role::create(['value' => 'Default', 'translation_key' => $default]);
        Role::create(['value' => 'Private advertiser', 'translation_key' => $privateAdvertiser]);
        Role::create(['value' => 'Business advertiser', 'translation_key' => $businessAdveriser]);
        */
        Advert::create(['title' => 'Want to rent a car?', 'description' => 'I have a nice clean car to rent out.', 'owner_id' => '1']);
    }
}
