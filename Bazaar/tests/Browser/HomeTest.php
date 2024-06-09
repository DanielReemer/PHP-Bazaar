<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Advert;
use App\Models\User;
use Faker\Factory as Faker;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * Create a new advert using Faker.
     *
     * @return array
     */
    protected function createAdvertWithFaker() : array
    {
        $faker = Faker::create();

        $user = User::factory()->create();

        $advert = Advert::create([
            'Title' => $faker->sentence,
            'Description' => $faker->paragraph,
            'owner_id' => $user->id,
        ]);
        return $advert->toArray();
    }

    /**
     * Test recent advertisements.
     *
     * @return void
     */
    public function testRecentAdvertisements() : void
    {
        sleep(5);
        $advertData = $this->createAdvertWithFaker();
        $this->browse(function (Browser $browser) use ($advertData) {
            $browser->visitRoute('home')
                    ->click('#advert-' . $advertData['id'])
                    ->assertSee($advertData['Title']);
        });
    }
}
