<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LinkedAdvert extends Model
{
    protected $fillable = [
        'advert_id',
        'linked_id',
    ];

    public function advert(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }

    public function linked(): BelongsTo
    {
        return $this->belongsTo(Advert::class);
    }
}
