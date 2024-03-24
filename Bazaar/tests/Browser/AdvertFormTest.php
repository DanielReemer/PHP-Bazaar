<?php

namespace Tests\Browser;

use App\Http\Controllers\AdvertController;
use App\Models\Advert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use SebastianBergmann\Type\VoidType;
use Tests\DuskTestCase;
use App\Models\User;

class AdvertFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $testUser;
    protected $maximumNumberOfPostReachMessage;

    public function setUp() : void
    {
        parent::setUp();
        $this->testUser = User::find(2);
        $this->maximunNumberOfPostReachMessage = 'Maximum number of ads have been posted.';
    }

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

    public function testRedirectedToDashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visit('/new-advert')
                ->type('title', 'This is my title')
                ->type('description', 'This is my description')
                ->press('submitAdvertForm')
                ->assertRouteIs('dashboard');
        });
    }

    public function testCannotContinueWithEmptyTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visit('/new-advert')
                ->type('description', 'this is my description')
                ->press('submitAdvertForm')
                ->assertPathIs('/new-advert');
        });
    }

    public function testCannotContinueWithEmptyDescription()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visit('/new-advert')
                ->type('title', 'this is my title')
                ->press('submitAdvertForm')
                ->assertPathIs('/new-advert');
        });
    }

    public function testErrorMessageAppearsForCharacterLimitExceededInTitleInputField()
    {
        $titleInput = '';
        for ($i = 0; $i <= 50; $i++) {
            $titleInput .= (string) $i;
        }

        $testCase = trans()->get('validation.max.string', ['attribute' => trans()->get('title'), 'max' => AdvertController::MAX_TITLE_LENGHT]);

        $this->browse(function (Browser $browser) use ($testCase, $titleInput) {
            $browser->loginAs($this->testUser)
                ->visit('/new-advert')
                ->type('title', $titleInput)
                ->type('description', "This is my description")
                ->press('submitAdvertForm')
                ->assertSee($testCase);
        });
    }

    public function testCannotCreateMoreThanFourRentalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM + 1;

        $this->browse(function (Browser $browser) use ($testCase, $numberOfPosts) {
            $this->makeValidPost($numberOfPosts, true);

            $browser->assertSee($testCase);
        });
    }

    public function testCannotCreateMoreThanFourNormalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM + 1;

        $this->browse(function (Browser $browser) use ($testCase, $numberOfPosts) {
            $this->makeValidPost($numberOfPosts, false);

            $browser->assertSee($testCase);
        });
    }

    public function testStillPostRentalAfterReachingNormalPostLimit()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfNormalPosts = AdvertController::MAX_ADVERT_NUM;

        $this->browse(function (Browser $browser) use ($testCase, $numberOfNormalPosts) {
            $this->makeValidPost($numberOfNormalPosts, false);
            $this->makeValidPost(1, true);

            $browser->assertDontSee($testCase);
        });
    }

    public function testStillPostNormalAfterReachingRentalPostLimit()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfRentalPosts = AdvertController::MAX_ADVERT_NUM;
        $this->browse(function (Browser $browser) use ($testCase, $numberOfRentalPosts) {
            $this->makeValidPost($numberOfRentalPosts, true);
            $this->makeValidPost(1, false);
            $browser->assertDontSee($testCase);
        });
    }

    private function makeValidPost(int $amount, bool $isRental) : void
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->browse(function (Browser $browser) use ($isRental) {
                $browser->loginAs($this->testUser)
                    ->visit('new-advert')
                    ->type('title', 'This is my title')
                    ->type('description', 'This is my description');

                if ($isRental) {
                    $browser->check('rental');
                }
                
                $browser->press('submitAdvertForm');
            });
        }
    }
}
