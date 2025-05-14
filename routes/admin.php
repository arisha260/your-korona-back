<?php

use App\Http\Controllers\TGBot\TelegramBotController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/me', fn () => auth()->user());

Route::get('/dashboard', function () {
    return response()->json(['message' => 'Welcome to Admin Dashboard']);
});
