<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'advert_id',
        'user_id',
        'title',
        'comment',
        'rating',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
