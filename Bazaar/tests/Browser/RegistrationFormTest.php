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

    public function setUp(): void
    {
        parent::setUp();

    }

    public function testWhetherAllInputsAreVisible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('register')->assertInputPresent('name');
            $browser->visit('register')->assertInputPresent('email');
            $browser->visit('register')->assertInputPresent('password');
            $browser->visit('register')->assertInputPresent('password_confirmation');
            $browser->visit('register')->assertInputPresent('role');
            $browser->visit('register')->assertPresent('button[name="registerUser"]');
        });
    }

    public function testWhetherAllOptionsArePresent()
    {
        $roleIds = Role::all()->pluck('id')->toArray();
        $this->browse(function (Browser $browser) use ($roleIds) {
            $browser->visit('register')->waitForInput('role')->assertSelectHasOptions('role', $roleIds);
        });
    }

    public function testRedirectToDashboardAfterRegistration()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        
        $this->browse(function (Browser $browser) use ($fakeUser, $role) {
            $browser->visit('register')
                ->type('name', $fakeUser->name)
                ->type('email', $fakeUser->email)
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertRouteIs('dashboard');
        });
    }

    public function testWhetherNameIsRequired()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The "name" field is required.';

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('email', $fakeUser->email)
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testWhetherEmailIsRequired()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The "email" field is required.';

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('name', $fakeUser->name)
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testWhetherAccountTypeIsRequired()
    {
        $fakeUser = User::factory()->makeOne();
        $errorMessage = 'The "Account Type" field is required.';

        $this->browse(function (Browser $browser) use ($fakeUser, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('name', $fakeUser->name)
                ->type('email', $fakeUser->email)
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testWhetherPasswordIsRequired()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The "password" field is required.';

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('name', $fakeUser->name)
                ->type('email', $fakeUser->email)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testWhetherPasswordConfirmationHasToMatchPasswordIsRequired()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The password field confirmation does not match.';

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('name', $fakeUser->name)
                ->type('email', $fakeUser->email)
                ->type('password', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testEmailMustBeOfValidFormat()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The email field must be a valid email address.';

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            $browser->type('name', $fakeUser->name)
                ->type('email', 'This is an invalid Email')
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

    public function testEmailIsUnique()
    {
        $fakeUser = User::factory()->makeOne();
        $role = Role::all()->find(1);
        $errorMessage = 'The email has already been taken.';
        $testUser = User::find(1);

        $this->browse(function (Browser $browser) use ($fakeUser, $role, $errorMessage, $testUser) {
            $browser->visit('register')
                ->script("document.querySelector('form').noValidate = true");
            
            $browser->type('name', $fakeUser->name)
                ->type('email', $testUser->email)
                ->type('password', $fakeUser->password)
                ->type('password_confirmation', $fakeUser->password)
                ->select('role', $role->id)
                ->press('registerUser')
                ->assertSee($errorMessage);
        });
    }

}
