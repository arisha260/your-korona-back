<?php

namespace App\Services\orders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class OrdersService
{

    public function getOrdersByStatus
    (
        int $perPage = 20,
        int $page = 1,
        string $sort = 'awaiting_payment',
        ?string $search = null
    ):  LengthAwarePaginator
    {

        try {

            $query = Order::query()
                ->when($search, function (Builder $query, string $search) {
                    $query->where('id', 'like', "%{$search}%");
                });;

            $this->applySorting($query, $sort);

            return $query->paginate($perPage, ['*'], 'page', max(1, $page))
                ->appends(request()->except('page'));

        } catch (\Exception $e) {
            Log::error('ProductService getProductByCategory error', [
                'error' => $e->getMessage(),
                'params' => compact('perPage', 'page', 'sort', 'search')
            ]);
            throw $e;
        }
    }

    protected function applySorting(Builder $query, string $sort): void
    {
        if (in_array($sort, ['awaiting_payment', 'processing', 'ready_for_pickup', 'shipped', 'delivered', 'cancelled'])) {
            $query->where('status', $sort);
        }

        $query->orderBy('id');
    }

}
