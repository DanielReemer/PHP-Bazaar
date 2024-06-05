<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LandingPage extends Model
{
    protected $fillable = [
        'url',
    ];

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'landing_page_id');
    }

    public function Components() : HasMany
    {
        return $this->hasMany(Component::class, 'landing_page_id');
    }
}
