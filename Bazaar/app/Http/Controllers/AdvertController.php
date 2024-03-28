<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\LandingspageUrl;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    const MAX_ADVERT_NUM = 4;
    const MAX_TITLE_LENGHT = 50;

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $account = Auth::user();
        $isBusinessAccount = $account->role()->value('value') === Role::ROLE_BUSINESS_ADVERTISER;
        $data = [
            'showUrlInput' => $isBusinessAccount,
        ];

        return view('adverts.new-advert', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maxTitleString = 'max:';
        $maxTitleString .= AdvertController::MAX_TITLE_LENGHT;

        $request->validate([
            'title' => ['required', 'string', $maxTitleString],
            'description' => ['string', 'max:255'],
            'customUrl' => ['nullable', 'url'],
        ]);

        if (! $this->limitCheck($request)) {
            return redirect()->back()->with('error', 'Maximum aantal advertenties is bereikt.');
        }

        $advert = new Advert();
        $advert->title = $request->title;
        $advert->description = $request->description;
        $advert->is_rental = $request->rental ?? 0;
        $advert->owner()->associate($request->user());
        $advert->save();

        if ($request->customUrl && Auth::user()->role()->value('value') === Role::ROLE_BUSINESS_ADVERTISER) {
            $landingPageUrl = new LandingspageUrl();
            $landingPageUrl->url = $request->customUrl;
            $landingPageUrl->advert()->associate($advert);
            $landingPageUrl->save();
        }

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advert $advert) : View
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advert $advert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
    }

    private function isRental(Request $request) : bool
    {
        $rental = $request->rental;
        if ($rental == 0) {
            return false;
        }

        return true;
    }

    private function limitCheck($request)
    {
        $user = $request->user() ?? Auth::user();
        $advertCount = $user->countAdverts($this->isRental($request));

        if ($advertCount >= AdvertController::MAX_ADVERT_NUM) {
            return false;
        }

        return true;
    }
}
