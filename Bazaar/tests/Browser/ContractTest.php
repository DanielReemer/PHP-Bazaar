<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;
use App\Models\User;

class ContractTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $userData;
    protected $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = $this->createTestUser();
        $this->userData = $this->user->toArray();
    }

    public function testUploadContract() : void
    {
        $filename = 'TestContract.pdf';
        $routename = 'admin.contract.show';
        $this->browse(function (Browser $browser) use ($filename, $routename) {
            $browser->loginAs($this->user)
                ->visitRoute($routename)
                ->attach('contract', base_path('tests/Data/'. $filename))
                ->press(strtoupper(__('contract.upload')))
                ->assertRouteIs($routename)
                ->assertSee($filename);
        });
    }


    /**
     * Create a new usert using Faker.
     *
     * @return array
     */
    protected function createTestUser() : User
    {
        $faker = Faker::create();

        $user = User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => $faker->password,
            'role_id' => 3,
            'is_admin' => true,
        ]);

        return $user;
    }
}
