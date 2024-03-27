<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingspageUrl extends Model
{
    use HasFactory;

    protected $table = 'landingspage_urls';

    protected $fillable = [
        'url',
        'advert_id',
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }
}
