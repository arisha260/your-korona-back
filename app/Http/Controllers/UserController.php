<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Services\CartService;
use App\Services\HomePageService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __invoke(Request $request, UserService $service, CartService $cartService)
    {
        try {
            return new UserResource($service->getData($request, $cartService));
        } catch (\Exception $e) {
            Log::error('User data error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Failed to load user data'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
