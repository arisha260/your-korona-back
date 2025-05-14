<?php

use App\Http\Controllers\TGBot\TelegramBotController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/', \App\Http\Controllers\HomePageController::class);

//Route::middleware(\App\Http\Middleware\HandleUserToken::class)->group(function () {
//
//});

Route::get('/me', \App\Http\Controllers\UserController::class);

Route::group(['namespace' => 'App\Http\Controllers\Cart', 'prefix' => 'cart'], function() {
    Route::get('/', \App\Http\Controllers\Cart\GetController::class);
    Route::post('/add', \App\Http\Controllers\Cart\AddController::class);
    Route::delete('/delete/{id}', \App\Http\Controllers\Cart\DeleteController::class);
    Route::delete('/clear', \App\Http\Controllers\Cart\ClearAllController::class);
    Route::patch('/update/{id}', \App\Http\Controllers\Cart\UpdateController::class);
});

Route::group(['namespace' => 'App\Http\Controllers\Favorites', 'prefix' => 'favorites'], function() {
    Route::get('/me', \App\Http\Controllers\Favorites\GetFavoriteController::class);
    Route::post('/toggle', \App\Http\Controllers\Favorites\ToggleFavoriteController::class);
});

Route::group(['namespace' => 'App\Http\Controllers\News', 'prefix' => 'news'], function() {
    Route::get('/', [\App\Http\Controllers\News\KoronaNewsController::class, 'index']);
    Route::get('/latest', [\App\Http\Controllers\News\KoronaNewsController::class, 'latest']);
    Route::get('/show/{slug}', [\App\Http\Controllers\News\KoronaNewsController::class, 'show']);
});


Route::group(['namespace' => 'App\Http\Controllers\Reviews', 'prefix' => 'reviews'], function() {
    Route::get('/', \App\Http\Controllers\Reviews\IndexController::class);
    Route::get('/latest', \App\Http\Controllers\Reviews\LatestController::class);
    Route::get('/show/{slug}', \App\Http\Controllers\Reviews\ShowController::class);
});


Route::group(['namespace' => 'App\Http\Controllers\Products', 'prefix' => 'products'], function() {
    Route::get('/', \App\Http\Controllers\Products\IndexController::class);
    Route::get('/search', \App\Http\Controllers\Products\SearchAllController::class);
    Route::get('/latest', \App\Http\Controllers\Products\PopularController::class);
    Route::get('/show/{slug}', \App\Http\Controllers\Products\ShowController::class);
    Route::get('/news', \App\Http\Controllers\Products\LastNewController::class);
    Route::get('/{slug}', \App\Http\Controllers\Products\ByCategory::class);
});


Route::group(['namespace' => 'App\Http\Controllers\Order', 'prefix' => 'order'], function() {
    Route::post('/create', \App\Http\Controllers\Order\CreateController::class);
});

Route::get('/categories', \App\Http\Controllers\Categories\IndexController::class);

Route::post('/telegram/webhook', [TelegramBotController::class, 'handle']);

Route::get('/test-mail', function () {
    $order = App\Models\Order::latest()->first();
    Mail::to('Lmorin2005@mail.ru')->send(new App\Mail\OrderCreated($order));
    return 'Письмо отправлено!';
});


Route::get('/redis-test', function () {
    Cache::put('test_key', 'Привет, Redis!', 600);
    return Cache::get('test_key'); // должен вернуть "Привет, Redis!"
});

Route::get('/admin/test', function () {
    return response()->json(auth()->user());
});
