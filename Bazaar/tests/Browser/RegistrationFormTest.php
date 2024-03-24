<?php

namespace Tests\Browser;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegistrationFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $pageName;
    protected $nameField;
    protected $emailField;
    protected $passwordField;
    protected $roleSelect;
    protected $passwordConfirmationField;
    protected $submitButton;
    protected $disableClientSideValidationScript;
    protected $testUser;
    protected $role;

    public function setUp() : void
    {
        parent::setUp();

        $this->pageName = 'register';
        $this->nameField = 'name';
        $this->emailField = 'email';
        $this->passwordField = 'password';
        $this->roleSelect = 'role';
        $this->passwordConfirmationField = 'password_confirmation';
        $this->submitButton = 'registerUser';
        $this->disableClientSideValidationScript = "document.querySelector('form').noValidate = true";

        $this->testUser = User::factory()->makeOne();
        $this->role = Role::all()->first();

    }

    public function testWhetherAllInputsAreVisible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->pageName)->assertInputPresent($this->nameField);
            $browser->visit($this->pageName)->assertInputPresent($this->emailField);
            $browser->visit($this->pageName)->assertInputPresent($this->passwordField);
            $browser->visit($this->pageName)->assertInputPresent($this->passwordConfirmationField);
            $browser->visit($this->pageName)->assertInputPresent($this->roleSelect);
            $browser->visit($this->pageName)->assertPresent('button[name="registerUser"]');
        });
    }

    public function testWhetherAllOptionsArePresent()
    {
        $roleIds = Role::all()->pluck('id')->toArray();
        $this->browse(function (Browser $browser) use ($roleIds) {
            $browser->visit($this->pageName)->waitForInput($this->roleSelect)->assertSelectHasOptions($this->roleSelect, $roleIds);
        });
    }

    public function testRedirectToDashboardAfterRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->pageName);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->press($this->submitButton)
                ->assertRouteIs('dashboard');
        });
    }

    public function testWhetherNameIsRequired()
    {
        $errorMessage = 'The "name" field is required.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->clear($this->nameField);

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testWhetherEmailIsRequired()
    {
        $errorMessage = 'The "email" field is required.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->clear($this->emailField);

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testWhetherAccountTypeIsRequired()
    {
        $errorMessage = 'The "Account Type" field is required.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $browser->type($this->nameField, $this->testUser->name)
                ->type($this->emailField, $this->testUser->email)
                ->type($this->passwordField, $this->testUser->password)
                ->type($this->passwordConfirmationField, $this->testUser->password);
            
            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testWhetherPasswordIsRequired()
    {
        $errorMessage = 'The "password" field is required.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->clear($this->passwordField);

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testWhetherPasswordConfirmationHasToMatchPassword()
    {
        $errorMessage = 'The password field confirmation does not match.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->clear($this->passwordConfirmationField)->type($this->passwordConfirmationField, 'this obviously does not match');

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testEmailMustBeOfValidFormat()
    {
        $errorMessage = 'The email field must be a valid email address.';

        $this->browse(function (Browser $browser) use ($errorMessage) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);

            $browser->clear($this->emailField)->type($this->emailField, 'this is an invalid email');

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    public function testEmailIsUnique()
    {
        $errorMessage = 'The email has already been taken.';
        $testUser = User::all()->first();

        $this->browse(function (Browser $browser) use ($errorMessage, $testUser) {
            $browser->visit($this->pageName)
                ->script($this->disableClientSideValidationScript);

            $this->fillForm($browser, $this->testUser, $this->role);
            $browser->clear($this->emailField)->type($this->emailField, $testUser->email);

            $this->submitFormAndAssertText($browser, $errorMessage);
        });
    }

    private function fillForm(Browser $browser, User $user, Role $role) : void
    {
        $browser->type($this->nameField, $user->name)
            ->type($this->emailField, $user->email)
            ->type($this->passwordField, $user->password)
            ->type($this->passwordConfirmationField, $user->password)
            ->select($this->roleSelect, $role->id);
    }

    private function submitFormAndAssertText(Browser $browser, string $message) : void
    {
        $browser->press($this->submitButton)
                ->assertSee($message);
    }

}
