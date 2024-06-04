<?php

namespace App\Http\Controllers;

use App\Models\FavoriteAdvert;
use Illuminate\Support\Facades\Auth;

class FavoriteAdvertController extends Controller
{
    public function show() {
        $favorites = FavoriteAdvert::where('user_id', Auth::id())
            ->with('advert')
            ->get();

        $data = [
            'favorites' => $favorites,
        ];

        return view('favorites', compact('data'));
    }

    public function update($id) {
        $favoriteAdvert = FavoriteAdvert::where('advert_id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $isFavorited = $favoriteAdvert != null;

        if($isFavorited) {
            $favoriteAdvert->delete();
        } else {
            FavoriteAdvert::create([
                'advert_id' => $id,
                'user_id' => Auth::user()->id,
            ]);
        }

        return to_route('advert.show', ['id' => $id]);
    }
}
