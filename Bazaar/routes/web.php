<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AdvertReviewController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FavoriteAdvertController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserReviewController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('advert')->group(function () {
    Route::get('{id}', [AdvertController::class, 'show'])->name('advert.show');
    Route::post('{id}/comment', [AdvertReviewController::class, 'store'])->name('advertReview.store');
    Route::post('{id}/favorite', [FavoriteAdvertController::class, 'update'])->name('favoriteAdvert.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('products/{type?}', [ProductController::class, 'show'])->name('products.show');
    Route::get('favorites', [FavoriteAdvertController::class, 'show'])->name('favorites.show');
    Route::get('new-advert', [AdvertController::class, 'create'])->middleware('postingRights')->name('new-advert');
    Route::post('new-advert', [AdvertController::class, 'store']);
    Route::post('new-advert-csv', [AdvertController::class, 'storeCsv'])->name('new-advert-csv');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('profile', [PageController::class, 'updateURL'])->name('url.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('contract', [ContractController::class, 'show'])->name('admin.contract.show');
    Route::post('contract', [ContractController::class, 'store'])->name('admin.contract.store');
    Route::get('contract/{rawFile}', [ContractController::class, 'downloadFile'])->name('admin.contract.download');
});

Route::middleware(['auth', 'auth.editor'])->group(function () {
    Route::get('page/{slug}/edit', [PageController::class, 'showEdit'])->name('page.showEdit');
    Route::post('page/{slug}/edit', [PageController::class, 'update'])->name('page.update');
});

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/{id}', [UserReviewController::class, 'store'])->name('userReview.store');
Route::get('page/{slug}', [PageController::class, 'show'])->name('page');

require __DIR__.'/auth.php';
