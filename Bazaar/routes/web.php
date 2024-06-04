<?php

use App\Http\Controllers\AdvertReviewController;
use App\Http\Controllers\FavoriteAdvertController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdvertController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('advert/{id}', [AdvertController::class, 'show'])->name('advert.show');
Route::post('advert/{id}/comment', [AdvertReviewController::class, 'store'])->name('advertReview.store');
Route::post('advert/{id}/favorite', [FavoriteAdvertController::class, 'update'])->name('favoriteAdvert.update');

Route::get('favorites', [FavoriteAdvertController::class, 'show'])->name('favorites.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('new-advert', [AdvertController::class, 'create'])
    ->middleware('auth', 'verified', 'postingRights')
    ->name('new-advert');

Route::post('new-advert', [AdvertController::class, 'store']);
Route::post('new-advert-csv' , [AdvertController::class,'storeCsv'])->name('new-advert-csv');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
