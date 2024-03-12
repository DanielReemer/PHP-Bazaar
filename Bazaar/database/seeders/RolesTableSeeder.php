<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $businessAdveriser = 'Roles.BusinessAdvertiser';
        $privateAdvertiser = 'Roles.PrivateAdvertiser';
        
        Role::create(['value' => 'Private advertiser', 'translation_key' => $privateAdvertiser]);
        Role::create(['value' => 'Business advertiser', 'translation_key' => $businessAdveriser]);
    }
}
