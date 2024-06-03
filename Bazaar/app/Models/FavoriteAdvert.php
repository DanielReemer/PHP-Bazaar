<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FavoriteAdvert extends Model
{

    protected $fillable = [
        'advert_id',
        'user_id',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    static function isFavorited($id)
    {
        return FavoriteAdvert::where('advert_id', $id)
            ->where('user_id', Auth::id())->exists();
    }
}
