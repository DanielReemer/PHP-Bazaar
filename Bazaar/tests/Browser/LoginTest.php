<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $user;
    private $userData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestUser();
    }

    private function createTestUser()
    {
        $faker = Faker::create();

        $this->userData = [
            'email' => $faker->safeEmail,
            'password' => 'password',
        ];

        $this->user = User::factory()->create([
            'email' => $this->userData['email'],
            'password' => bcrypt($this->userData['password']),
        ]);
    }

    public function testLoginForm()
    {
        $this->browse(function (Browser $browser) {
            $this->fillLoginForm($browser)
                 ->assertRouteIs('dashboard');
        });
    }

    private function fillLoginForm(Browser $browser): Browser
    {
        return $browser->visit('/login')
                       ->type('email', $this->userData['email'])
                       ->type('password', $this->userData['password'])
                       ->check('remember')
                       ->press(strtoupper(__('auth.login_button')));
    }
}
