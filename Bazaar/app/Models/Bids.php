<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bids extends Model
{
    use HasFactory;

    protected $fillable = [
        'advert_id',
        'user_id',
        'purchased',
        'money',
    ];

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
