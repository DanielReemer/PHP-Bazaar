<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Advert;
use App\Models\User;
use Faker\Factory as Faker;

class FavoriteTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $faker;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->faker = Faker::create();
    }

    public function testAddFavourite()
    {
        $advert = $this->createAdvert();

        $this->browse(function (Browser $browser) use ($advert) {
            $this->visitAdvertPage($browser, $advert);
            $this->addToFavorites($browser);
            $this->visitFavoritesPage($browser);
            $browser->assertSee($advert['Title']);
        });
    }

    public function testRemoveFavourite()
    {
        $advert = $this->createAdvert();

        $this->browse(function (Browser $browser) use ($advert)
        {
            $this->visitAdvertPage($browser, $advert);
            $this->addToFavorites($browser);
            $this->visitFavoritesPage($browser);
            $browser->assertSee($advert['Title']);
            $this->visitAdvertPage($browser, $advert);
            $this->removeFromFavorites($browser);
            $this->visitFavoritesPage($browser);
            $browser->assertDontSee($advert['Title']);
        });
    }

    protected function createAdvert() : array
    {
        $user = User::factory()->create();

        $advert = Advert::create([
            'Title' => $this->faker->sentence,
            'Description' => $this->faker->paragraph,
            'owner_id' => $user->id,
        ]);

        return $advert->toArray();
    }

    protected function visitAdvertPage(Browser $browser, array $advert)
    {
        $browser->loginAs($this->user)
                ->visitRoute('advert.show', ['id' => $advert['id']]);
    }

    protected function addToFavorites(Browser $browser)
    {
        $browser->press('favouriteButton');
    }

    protected function removeFromFavorites(Browser $browser)
    {
        $browser->press('favouriteButton');
    }

    protected function visitFavoritesPage(Browser $browser)
    {
        $browser->visitRoute('favorites.show');
    }
}
