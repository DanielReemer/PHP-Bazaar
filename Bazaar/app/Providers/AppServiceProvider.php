<?php

namespace App\Providers;

use App\Abstracts\AbstractAdvertCsvHandler;
use App\Http\Controllers\AdvertController;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ICsvHandler;
use App\Models\AdvertCsvHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(AdvertController::class)
            ->needs(AbstractAdvertCsvHandler::class)
            ->give(AdvertCsvHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
