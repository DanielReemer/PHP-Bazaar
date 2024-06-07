<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\UserReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($id) : View
    {
        $userData = User::where('id', $id)
            ->with('adverts')
            ->first();

        $reviews = UserReview::where('user_id', $id)
            ->get();

        $user = [
            'name' => $userData->name,
            'id' => $userData->id,
            'adverts' => $userData->adverts,
            'reviews' => $reviews,
        ];

        $data = [
            'user' => $user,
        ];

        return view('profile/public-view', compact('data'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) : View
    {
        $role = $request->user()->role;
        return view('profile.edit', [
            'user' => $request->user(),
            'role' => $role,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request) : RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->user();
        if ($request->has('api')) {
            if (! $user->api_key) {
                $user->api_key = User::generateApiKey();
            }
        } else {
            if ($user->api_key) {
                $user->api_key = null;
            }
        }
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request) : RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
