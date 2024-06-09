<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Advert;
use Faker\Factory as Faker;
use App\Models\HiredProduct;

class AgendaOverviewTest extends DuskTestCase
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

    public function test_my_products_for_expiration_date()
    {
        $advertData = $this->createMultipleAdverts(3);

        $this->browse(function (Browser $browser) use ($advertData) {
            $browser->loginAs($this->user)->visitRoute('products.show', ['type' => 'my_product']);
            $this->assertAdvertDataOnBrowser($browser, $advertData);
        });
    }

    public function test_hired_out_products()
    {
        $advertData = $this->createAdvertWithFaker();
        $testUser = User::factory()->create();

        $hiredProduct = $this->createHiredProduct($advertData, $testUser);

        $this->browse(function (Browser $browser) use ($advertData, $hiredProduct, $testUser) {
            $browser->loginAs($this->user)->visitRoute('products.show', ['type' => 'hired_out']);
            $this->assertHiredProductOnBrowser($browser, $advertData, $hiredProduct, $testUser);
        });
    }

    public function test_hired_products()
    {
        $advertData = $this->createAdvertWithFaker();
        $testUser = User::factory()->create();
        $hiredProduct = $this->createHiredProduct($advertData, $testUser);

        $this->browse(function (Browser $browser) use ($advertData, $hiredProduct, $testUser) {

            $browser->loginAs($testUser)
                ->visitRoute('products.show', ['type' => 'hired'])
                ->assertSee($advertData['Title'])
                ->assertSee($advertData['Description'])
                ->assertSee($hiredProduct->getFormattedFromAttribute())
                ->assertSee($hiredProduct->getFormattedToAttribute());
        });


    }

    protected function createMultipleAdverts(int $numberToMake) : array
    {
        $advertData = [];
        for ($count = 0; $count < $numberToMake; $count++) {
            array_push($advertData, $this->createAdvertWithFaker());
        }
        return $advertData;
    }

    protected function assertAdvertDataOnBrowser(Browser $browser, array $advertData) : void
    {
        foreach ($advertData as $advert) {
            $browser->assertSee($advert['Title'])
                ->assertSee($advert['Description'])
                ->assertSee($advert['expiration_date']);
        }
    }

    protected function createAdvertWithFaker() : array
    {
        $advert = Advert::create([
            'Title' => $this->faker->sentence,
            'Description' => $this->faker->paragraph,
            'owner_id' => $this->user->id,
        ]);

        return $advert->toArray();
    }

    protected function createHiredProduct(array $advertData, User $testUser) : HiredProduct
    {
        return HiredProduct::create([
            'advert_id' => $advertData['id'],
            'user_id' => $testUser->id,
            'from' => now(),
            'to' => now()->addDays(7),
        ]);
    }

    protected function assertHiredProductOnBrowser(Browser $browser, array $advertData, HiredProduct $hiredProduct, User $testUser) : void
    {
        $browser->assertSee($advertData['Title'])
            ->assertSee($advertData['Description'])
            ->assertSee($hiredProduct->getFormattedFromAttribute())
            ->assertSee($hiredProduct->getFormattedToAttribute())
            ->assertSee($testUser->name);
    }
}
