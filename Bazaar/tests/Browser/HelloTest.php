<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Role;
use Faker\Factory as Faker;

class HelloTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */
    public function testExample() : void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Laravel');
        });
    }

    public function testFlowToUseCsvFile()
    {
        $this->browse(function (Browser $browser) {
            $userData = $this->createUser();

            /*$browser->visitRoute('register')
                ->assertSee(__('registration.Register')) // Ensure the register form is loaded
                ->type('name', $userData['name'])
                ->type('email', $userData['email'])
                ->select('role', $userData['role'])// Select the user's role
                ->type('password', $userData['password'])
                ->type('password_confirmation', $userData['password'])
                ->press('registerUser');
            */

            $user = User::factory()->createOne($userData);

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertPathIs('/dashboard')
                ->assertSeeLink('Create New Advert')

                ->visitRoute('new-advert')
                ->assertRouteIs('new-advert')->screenshot('hey')

                ->attach('csv_file', base_path('tests/Data/TestCodeForAdverts.csv'))
                ->press('submitCsv')
                ->assertSee(__('advert.successMultiple'))->screenshot("hey");
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
