<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductCardResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LastNewController extends Controller
{
    public function __invoke(Request $request, ProductService $service)
    {
        try {
            $page = max(1, (int) $request->input('page', 1));
            $limit = min(20, (int) $request->input('limit', 5));

            [$items, $total, $nextPage] = $service->getNewProducts($page, $limit);

            return response()->json([
                'data' => ProductCardResource::collection($items),
                'nextPage' => $nextPage,
                'hasNextPage' => $nextPage !== null,
                'total' => $total,
            ]);

        } catch (\Exception $e) {
            Log::error('LastNewController error', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'message' => 'Failed to load new products'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
