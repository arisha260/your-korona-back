<?php

namespace App\Http\Controllers\Order\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Order;
use App\Services\cache\OrdersService;
use Illuminate\Support\Facades\Gate;

class ShowOrderController extends Controller
{

    public function __invoke($id)
    {
        $order = Order::findOrFail($id);

        Gate::authorize('view', $order);

        return new OrderResource($order);
    }
}
