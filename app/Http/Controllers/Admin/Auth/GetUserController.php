<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminResource;
use Illuminate\Http\Request;

class GetUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user(); // Получаем авторизованного пользователя

        return new AdminResource($user); // Возвращаем данные через ресурс
    }
}
