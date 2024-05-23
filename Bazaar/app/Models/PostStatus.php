<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "translation_key",
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Advert::class);
    }
}
