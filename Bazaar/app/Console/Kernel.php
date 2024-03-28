<?php

namespace App\Console;

use App\Models\Advert;
use App\Models\PostStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
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
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
