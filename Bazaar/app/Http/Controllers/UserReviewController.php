<?php

namespace App\Http\Controllers;

use App\Models\UserReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function store($id, Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        UserReview::create([
            'user_id' => $id,
            'reviewer_id' => $request->user()->id,
            'title' => $request['title'],
            'comment' => $request['review'],
        ]);

        return to_route('profile.show', ['id' => $id]);
    }
}
