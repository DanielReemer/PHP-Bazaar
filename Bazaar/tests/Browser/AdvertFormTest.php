<?php

namespace Tests\Browser;

use App\Http\Controllers\AdvertController;
use App\Models\Advert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Faker\Factory as Faker;

class AdvertFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $testUser;
    protected $maximumNumberOfPostReachMessage;
    protected $newAdvertPath;
    protected $descriptionFieldName;
    protected $titleFieldName;
    protected $submitButtonName;
    protected $dashboardRouteName;

    protected $faker;

    public function setUp() : void
    {
        parent::setUp();
        $this->testUser = User::find(2);
        $this->maximumNumberOfPostReachMessage = 'Maximum number of ads have been posted.';
        $this->newAdvertPath = '/new-advert';
        $this->descriptionFieldName = 'description';
        $this->titleFieldName = 'title';
        $this->submitButtonName = 'submitAdvertForm';
        $this->dashboardRouteName = 'dashboard';

        $this->faker = Faker::create();

    }

    public function testRedirectedToDashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visit($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->dashboardRouteName);
        });
    }

    public function testCannotCreateMoreThanFourRentalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM;
        $this->makeValidPost($numberOfPosts, true);

        $this->browse(function (Browser $browser) use ($testCase) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->check('rental')
                ->press($this->submitButtonName)
                ->assertSee($testCase);
        });
    }

    public function testCannotCreateMoreThanFourNormalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM;
        $this->makeValidPost($numberOfPosts, false);

        
        $this->browse(function (Browser $browser) use ($testCase) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->press($this->submitButtonName)
                ->assertSee($testCase);
        });
    }

    public function testStillPostRentalAfterReachingNormalPostLimit()
    {
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM;
        $this->makeValidPost($numberOfPosts, false);

        
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->check('rental')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->dashboardRouteName);
        });
    }

    public function testStillPostNormalAfterReachingRentalPostLimit()
    {

        $numberOfPosts = AdvertController::MAX_ADVERT_NUM;
        $this->makeValidPost($numberOfPosts, true);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->dashboardRouteName);
        });
    }

    private function makeValidPost(int $amount, bool $isRental) : void
    {
        for ($i = 0; $i < $amount; $i++) {

            $this->createAdvert($this->testUser, $isRental);
        }
    }

    private function createAdvert(User $user, bool $isRental) : array
    {

        $advert = Advert::create([
            'Title' => $this->faker->sentence,
            'Description' => $this->faker->paragraph,
            'owner_id' => $user->id,
            'is_rental' => $isRental,
        ]);

        return $advert->toArray();
    }
}
