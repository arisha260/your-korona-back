<?php

use Illuminate\Support\Facades\Route;


Route::get('/', \App\Http\Controllers\HomePageController::class);

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

Route::group(['namespace' => 'App\Http\Controllers\Favorites', 'prefix' => 'favorites'], function() {
    Route::get('/me', \App\Http\Controllers\Favorites\GetFavoriteController::class);
    Route::post('/toggle', \App\Http\Controllers\Favorites\ToggleFavoriteController::class);
});

Route::group(['namespace' => 'App\Http\Controllers\Cart', 'prefix' => 'cart'], function() {
    Route::get('/add', \App\Http\Controllers\Cart\AddController::class);
    Route::delete('/delete/{id}', \App\Http\Controllers\Cart\DeleteController::class);
    Route::delete('/clear', \App\Http\Controllers\Cart\ClearAllController::class);
    Route::patch('/update/{id}', \App\Http\Controllers\Cart\UpdateController::class);
});


Route::get('/categories', \App\Http\Controllers\Categories\IndexController::class);
