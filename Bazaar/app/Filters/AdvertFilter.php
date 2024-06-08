<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AdvertFilter
{
    public static function apply(Builder $query, $filter)
    {
        if ($filter === 'rentals') {
            $query->where('is_rental', 1);
        } elseif ($filter === 'non_rentals') {
            $query->where('is_rental', 0);
        } elseif ($filter === 'giving') {
            $query->giving();
        } elseif ($filter == 'recieving') {
            $query->recieving();
        }
    }
}