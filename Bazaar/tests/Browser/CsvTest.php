<?php

namespace Tests\Browser;

use App\Models\Role;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CsvTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testFlowToUseCsvFile()
    {
        $this->browse(function (Browser $browser) {
            $userData = $this->createUser();

            $browser->visitRoute('register')
                ->assertSee(__('registration.Register'))
                ->type('name', $userData['name'])
                ->type('email', $userData['email'])
                ->select('role', $userData['role_id'])
                ->type('password', $userData['password'])
                ->type('password_confirmation', $userData['password'])
                ->press('registerUser')
                ->assertPathIs('/dashboard')
                
                ->assertSeeLink('Create New Advert')
                ->clickLink('Create New Advert')
                ->assertRouteIs('new-advert')

                ->attach('csv_file', base_path('tests/Data/TestCodeForAdverts.csv'))
                ->press('submitCsv')
                ->assertSee(__('advert.successMultiple'));
        });
    }

    private function createUser() : array
    {
        $faker = Faker::create();
        $businessAdvertiserRole = Role::where('value', 'Business advertiser')->firstOrFail();
        $userData = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password123',
            'role_id' => 3,
            'api_key' => User::generateApiKey(),
            'is_admin' => false,
        ];

        return $userData;
    }
}
