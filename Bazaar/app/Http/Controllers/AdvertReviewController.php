<?php

namespace App\Http\Controllers;

use App\Models\AdvertReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdvertReviewController extends Controller
{
    public function store($id, Request $request): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|min:0|max:5',
            'title' => 'required|max:255',
        ]);

        AdvertReview::create([
            'advert_id' => $id,
            'user_id' => $request->user()->id,
            'title' => $request['title'],
            'comment' => $request['review'],
            'rating' => $request['rating'],
        ]);

        return to_route('advert.show', ['id' => $id]);
    }
}
