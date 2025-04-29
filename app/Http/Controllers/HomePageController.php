<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageResource;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Services\HomePageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HomePageController extends Controller
{
    public function __invoke(HomePageService $service)
    {
        try {
            return new HomePageResource($service->getData());
        } catch (\Exception $e) {
            Log::error('HomePageController error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Failed to load home page data'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
