<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostStatus;
use App\Models\Advert;

class ExpireAdvertsCommand extends Command
{
    protected $signature = 'expire:adverts';
    protected $description = 'Updates the status of available posts that have surpassed their expiration date to "expired".';

    public function handle()
    {
        $expiredStatus = PostStatus::where("name", "expired")->first();
        $adverts = Advert::where('expiration_date', '<=', now())
            ->whereHas('postStatus', function ($query) {
                $query->where('name', 'available');
            })
            ->get();

        $adverts->each(function (Advert $advert) use ($expiredStatus) {
            $advert->postStatus()->associate($expiredStatus);
            $advert->save();
        });

        $this->info('Adverts expired successfully.');
    }
}
