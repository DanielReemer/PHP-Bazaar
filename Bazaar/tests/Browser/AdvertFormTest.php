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
    protected $newAdvertPath;
    protected $descriptionFieldName;
    protected $titleFieldName;
    protected $submitButtonName;
    protected $dashboardRouteName;
    protected $loginRouteName;
    protected $disableClientSideValidationScript;

    public function setUp() : void
    {
        parent::setUp();
        $this->testUser = User::factory()->create();
        $this->maximumNumberOfPostReachMessage = 'Reached Maximum.';
        $this->newAdvertPath = 'new-advert';
        $this->descriptionFieldName = 'description';
        $this->titleFieldName = 'title';
        $this->submitButtonName = 'submitAdvertForm';
        $this->dashboardRouteName = 'dashboard';
        $this->loginRouteName = 'login';
        $this->disableClientSideValidationScript = "document.querySelector('form').noValidate = true";
    }


    public function testRedirectedToDashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'This is my title')
                ->type($this->descriptionFieldName, 'This is my description')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->dashboardRouteName);
        });
    }

    public function testCannotContinueWithEmptyTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath);
            $browser->script($this->disableClientSideValidationScript);
            $browser->type($this->descriptionFieldName, 'this is my description')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->newAdvertPath);
        });
    }

    public function testCannotContinueWithEmptyDescription()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser)
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, 'this is my title')
                ->press($this->submitButtonName)
                ->assertRouteIs($this->newAdvertPath);
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
                ->visitRoute($this->newAdvertPath)
                ->type($this->titleFieldName, $titleInput)
                ->type($this->descriptionFieldName, "This is my description")
                ->press($this->submitButtonName)
                ->assertSee($testCase);
        });
    }

    public function testCannotCreateMoreThanFourRentalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM + 1;

        $this->makeSureUserDoesntHaveAnyRentalPosts($this->testUser);
        $this->browse(function (Browser $browser) use ($testCase, $numberOfPosts) {
            $this->makeValidPost($numberOfPosts, true);

            $browser->assertSee($testCase);
        });
    }

    public function testCannotCreateMoreThanFourNormalPosts()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfPosts = AdvertController::MAX_ADVERT_NUM + 1;

        $this->makeSureUserDoesntHaveAnyNormalPosts($this->testUser);
        $this->browse(function (Browser $browser) use ($testCase, $numberOfPosts) {
            $this->makeValidPost($numberOfPosts, false);

            $browser->assertSee($testCase);
        });
    }

    public function testStillPostRentalAfterReachingNormalPostLimit()
    {
        $numberOfNormalPosts = AdvertController::MAX_ADVERT_NUM;

        $this->makeSureUserDoesntHaveAnyPosts($this->testUser);
        $this->browse(function (Browser $browser) use ($numberOfNormalPosts) {
            $this->makeValidPost($numberOfNormalPosts, false);
            $this->makeValidPost(1, true);

            $browser->assertRouteIs($this->dashboardRouteName);
        });
    }

    public function testStillPostNormalAfterReachingRentalPostLimit()
    {
        $testCase = $this->maximumNumberOfPostReachMessage;
        $numberOfRentalPosts = AdvertController::MAX_ADVERT_NUM;

        $this->makeSureUserDoesntHaveAnyPosts($this->testUser);
        $this->browse(function (Browser $browser) use ($testCase, $numberOfRentalPosts) {
            $this->makeValidPost($numberOfRentalPosts, true);
            $this->makeValidPost(1, false);
            $browser->assertDontSee($testCase);
        });
    }

    public function testRedirectToLoginWhenNotSignedIn()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->testUser);
            $browser->logout();
            $browser->visitRoute($this->newAdvertPath)
                ->assertRouteIs('login');
        });
    }

    private function makeValidPost(int $amount, bool $isRental) : void
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->browse(function (Browser $browser) use ($isRental) {
                $browser->loginAs($this->testUser)
                    ->visitRoute($this->newAdvertPath)
                    ->type($this->titleFieldName, 'This is my title')
                    ->type($this->descriptionFieldName, 'This is my description');

                if ($isRental) {
                    $browser->check('rental');
                }

                $browser->press($this->submitButtonName);
            });
        }
    }

    private function makeSureUserDoesntHaveAnyPosts(User $testUser) : void
    {
        $testUser->deleteAllAdverts();

        return;
    }

    private function makeSureUserDoesntHaveAnyNormalPosts(User $testUser) : void
    {
        $testUser->deleteNormalAdverts();

        return;
    }

    private function makeSureUserDoesntHaveAnyRentalPosts(User $testUser) : void
    {
        $testUser->deleteRentalAdverts();

        return;
    }
}
