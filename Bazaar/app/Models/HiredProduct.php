<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiredProduct extends Model
{
    protected $fillable = [
        'advert_id',
        'user_id',
        'from',
        'to',
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
