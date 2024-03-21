<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    const MAX_ADVERT_NUM = 4;

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('adverts.new-advert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check wheter Post Limit Has Been reached;
        if (! ($this->limitCheck(($request)))) {
            return redirect()->back()->with('error', 'Maximum number of ads have been posted.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:255'],
        ]);

        $advert = new Advert();
        $advert->title = $request->title;
        $advert->description = $request->description;
        $advert->is_rental = $request->rental ?? 0;
        $advert->owner()->associate($request->user() ?? Auth::user());
        $advert->save();

        // TODO: Change to a sort of dashboard; 
        return view('dashboard');
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
