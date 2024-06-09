<?php

namespace Tests\Helpers;

use App\Models\User;
use Laravel\Dusk\Browser;

class ContractTestHelper
{
    protected $user;
    protected $filename;
    protected $routename;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->filename = 'TestContract.pdf';
        $this->routename = 'admin.contract.show';
    }

    public function run(Browser $browser)
    {
        $browser->loginAs($this->user)
            ->visitRoute($this->routename)
            ->attach('contract', base_path('tests/Data/'. $this->filename))
            ->press(strtoupper(__('contract.upload')))
            ->assertRouteIs($this->routename)
            ->assertSee($this->filename);
    }
}
