<?php

namespace App\Http\Controllers\Order\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Order;
use App\Services\orders\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GetOrderController extends Controller
{

    protected $orderService;

    public function __construct(OrdersService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function __invoke(Request $request)
    {

        Gate::authorize('viewAny', Order::class);

        $orders = $this->orderService->getOrdersByStatus(
            perPage: $request->input('per_page', 20),
            page: $request->input('page', 1),
            sort: $request->input('sort', 'waiting'),
            search: $request->input('search')
        );

        return OrderResource::collection($orders)->additional([
            'nextPage' => $orders->hasMorePages() ? $orders->currentPage() + 1 : null,
            'total' => $orders->total(),
        ]);
    }
}
