<?php

namespace App\Http\Controllers\Order\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Mail\OrderUpdated;
use App\Models\Order;
use App\Notifications\OrderUpdatedTelegramNotification;
use App\Services\cache\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UpdateOrderController extends Controller
{

    protected $orderService;

    public function __construct(OrdersService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function __invoke(UpdateOrderRequest $request, $id)
    {

        $order = Order::findOrFail($id);

        Gate::authorize('update', $order);

        $order->update([
            'client_name' => $request->client_name,
            'client_tel' => $request->client_tel,
            'client_email' => $request->client_email,
            'client_city' => $request->client_city,
            'client_address' => $request->client_address,
            'client_index' => $request->client_index,
        ]);

        $this->orderService->clearCache();

        Notification::route('telegram', config('services.telegram.chat_id'))
            ->notify(new OrderUpdatedTelegramNotification($order));

        Mail::to($order->client_email)->send(new OrderUpdated($order));

        return response()->json(['message' => 'Заказ успешно обновлен', 'order_id' => $order->id], 201);
    }
}
