<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AdvertFilter
{
    public static function apply(Builder $query, $filter)
    {
        date_default_timezone_set('Europe/Amsterdam');
        $date = date('Y/m/d h:i:s', time());

        switch($filter) {
            case 'rentals':
                $query->where('is_rental', 1);
                break;
            case 'non_rentals':
                $query->where('is_rental', 0);
                break;
            case 'giving':
                $query->giving();
                break;
            case 'recieving':
                $query->recieving();
                break;
            case 'past':
                $query->where('from', '<', $date)
                    ->where('to', '<', $date);
                break;
            case 'current':
                $query->where('from', '<', $date)
                    ->where('to', '>', $date);
                break;
            case 'future':
                $query->where('from', '>', $date)
                    ->where('to', '>', $date);
                break;
        }
    }
}
