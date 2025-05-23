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
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/me', GetUserController::class);
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
        Route::post('/register', [RegisteredUserController::class, 'store']);


        Route::get('/categories', \App\Http\Controllers\Categories\admin\AdminIndexController::class);
        Route::delete('/delete/category/{id}', \App\Http\Controllers\Categories\admin\AdminDeleteController::class);
        Route::post('/delete/category/transfer', \App\Http\Controllers\Categories\admin\AdminTransferProductsController::class);
        Route::post('/delete/category/products', \App\Http\Controllers\Categories\admin\AdminDeleteWithProductsController::class);
        Route::post('/category/add', \App\Http\Controllers\Categories\admin\AdminAddCategoryController::class);
        Route::post('/category/update/{id}', \App\Http\Controllers\Categories\admin\AdminUpdateController::class);
    });

    // 🕒 Можно будет позже раскомментировать, если понадобится:
    /*
    // Восстановление пароля
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
    Route::post('/reset-password', [NewPasswordController::class, 'store']);

    // Подтверждение email
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:sanctum', 'signed'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:sanctum'])
        ->name('verification.send');
    */
});



Route::middleware(['auth:sanctum'])->get('/test', function () {
    return response()->json(auth()->user());
});

