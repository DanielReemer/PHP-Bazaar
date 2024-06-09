<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Advert;
use App\Models\User;
use Faker\Factory as Faker;

class ReviewTest extends DuskTestCase
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

    public function testCreateAdvertReview() : void
    {
        $data = $this->generateReviewData($this->createAdvert());

        $this->browse(function (Browser $browser) use ($data) {
            $this->submitAdvertReview($browser, 'advert.show', $data);
            $this->assertReview($browser, 'advert.show', $data);
        });
    }

    public function testCreateUserReview() : void
    {
        $data = $this->generateReviewData(User::factory()->create());

        $this->browse(function (Browser $browser) use ($data) {
            $this->submitUserReview($browser, 'profile.show', $data);
            $this->assertReview($browser, 'profile.show', $data);
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

    protected function generateReviewData($subject) : array
    {
        return [
            'subject' => $subject,
            'title' => $this->faker->sentence,
            'review' => $this->faker->paragraph,
            'user' => User::factory()->create(),
        ];
    }

    protected function submitAdvertReview(Browser $browser, string $route, array $data) : void
    {
        $browser->loginAs($this->user)
                ->visitRoute($route, ['id' => $data['subject']['id']])
                ->type('title', $data['title'])
                ->type('rating', '5')
                ->type('review', $data['review'])
                ->press(__('advert.submit_review'));
    }

    protected function submitUserReview(Browser $browser, string $route, array $data) : void
    {
        $browser->loginAs($this->user)
                ->visitRoute($route, ['id' => $data['subject']->id])
                ->type('title', $data['title'])
                ->type('review', $data['review'])
                ->press(__('advert.submit_review'));
    }

    protected function assertReview(Browser $browser, string $route, array $data) : void
    {
        $browser->loginAs($data['user'])
                ->visitRoute($route, ['id' => $data['subject']['id']])
                ->assertSee($data['title'])
                ->assertSee($data['review']);
    }
}
