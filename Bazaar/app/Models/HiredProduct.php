<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getFormattedToAttribute()
    {
        return Carbon::parse($this->to)->format('d-m-Y');
    }

    public function getFormattedFromAttribute()
    {
        return Carbon::parse($this->from)->format('d-m-Y');
    }

    public function scopeGiving($query)
    {
        return $query->whereDate('to', '<', now())
            ->orWhereDate('from', '>', now());
    }

    public function scopeRecieving($query)
    {
        return $query->whereDate('from', '<=', now())
            ->whereDate('to', '>=', now());
    }
}
