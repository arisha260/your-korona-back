<?php

namespace App\Http\Controllers\Order\admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Notifications\OrderStatusUpdatedTelegramNotification;
use App\Services\cache\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UpdateStatusOrderController extends Controller
{

    protected $orderService;

    public function __construct(OrdersService $orderService)
    {
        $this->orderService = $orderService;
    }


    public function __invoke(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|string|in:waiting,processing,shipped,delivered,cancelled',
            'message' => 'nullable|string|max:1000',
        ]);


        $order = Order::findOrFail($id);

        Gate::authorize('update', $order);

        $order->update(['status' => $request->status]);

        $this->orderService->clearCache();

        Notification::route('telegram', config('services.telegram.chat_id'))
            ->notify(new OrderStatusUpdatedTelegramNotification($order));

        $message = $request->message ? nl2br(e($request->message)) : null;
        Mail::to($order->client_email)->send(new OrderStatusUpdated($order, $message));

        return response()->json(['message' => 'Заказ успешно обновлен', 'order_id' => $order->id], 201);
    }
}
