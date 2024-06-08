<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoughtProduct extends Model
{
    protected $fillable = [
        'advert_id',
        'user_id',
    ];

    public function advert() : BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
