<?php

namespace App\Http\Controllers\Order\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Order;
use App\Services\cache\OrdersService;
use Illuminate\Support\Facades\Gate;

class GetOrderController extends Controller
{

    protected $orderService;

    public function __construct(OrdersService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function __invoke()
    {

        Gate::authorize('viewAny', Order::class);

        $orders = $this->orderService->getAll();

        return OrderResource::collection($orders);
    }
}
