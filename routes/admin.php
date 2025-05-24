<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\GetUserController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Важно: web — для сессий, cookies, CSRF и работы sanctum через браузер
Route::middleware(['web'])->group(function () {

    // 🔓 Публичные маршруты (логин, регистрация)
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // 🔐 Приватные маршруты — только для аутентифицированного админа
    Route::middleware(['auth:sanctum', 'role:admin,super-admin'])->group(function () {
        Route::get('/me', GetUserController::class);
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

        Route::get('/categories', \App\Http\Controllers\Categories\admin\AdminIndexController::class);
        Route::delete('/delete/category/{id}', \App\Http\Controllers\Categories\admin\AdminDeleteController::class);
        Route::post('/delete/category/transfer', \App\Http\Controllers\Categories\admin\AdminTransferProductsController::class);
        Route::post('/delete/category/products', \App\Http\Controllers\Categories\admin\AdminDeleteWithProductsController::class);
        Route::post('/category/add', \App\Http\Controllers\Categories\admin\AdminAddCategoryController::class);
        Route::post('/category/update/{id}', \App\Http\Controllers\Categories\admin\AdminUpdateController::class);

        Route::group(['namespace' => 'App\Http\Controllers\Users\Admin', 'prefix' => 'users'], function () {
            Route::get('/admins', \App\Http\Controllers\Users\Admin\AdminIndexController::class);
        });
    });

    Route::middleware(['auth:sanctum', 'role:super-admin'])->group(function () {
        Route::post('/register', [RegisteredUserController::class, 'store']);
        Route::delete('/users/admins/delete/{id}', \App\Http\Controllers\Users\Admin\AdminDeleteController::class);
    });
});



Route::middleware(['auth:sanctum'])->get('/test', function () {
    return response()->json(auth()->user());
});

