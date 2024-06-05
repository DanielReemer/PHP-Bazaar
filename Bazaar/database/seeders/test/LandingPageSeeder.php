<?php

namespace Database\Seeders\test;

use App\Models\LandingPage;
use App\Models\User;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $landingPage = LandingPage::create([]);
        $admin = User::where('is_admin', 1)
            ->first();

        $admin->landing_page_id = $landingPage->id;
        $admin->update();
    }
}
