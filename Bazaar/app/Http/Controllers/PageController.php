<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function show($slug)
    {

        return view('');
    }

    public function updateURL(Request $request) : RedirectResponse
    {
        $request->validateWithBag('updateUrl', [
            'url' => 'nullable|unique:landing_pages|max:100|lowercase|alpha_dash:ascii',
        ]);

        $landingpage = LandingPage::where('id', Auth::user()->landing_page_id)
            ->first();
        $landingpage->url = $request->url;
        $landingpage->update();

        return to_route('profile.edit');
    }
}
