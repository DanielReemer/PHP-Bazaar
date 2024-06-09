<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReturnImages extends Model
{
    protected $fillable = [
        'hired_product_id',
        'url',
    ];

    public function hiredProduct(): BelongsTo
    {
        return $this->belongsTo(HiredProduct::class);
    }
}
