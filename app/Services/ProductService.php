<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function getPopular(int $limit = 10)
    {
        try {
            return Product::orderByDesc('views')
                ->take($limit)
                ->get();
        } catch (\Exception $e) {
            Log::error('ProductService getPopular error', [
                'error' => $e->getMessage(),
                'limit' => $limit
            ]);
            throw $e;
        }
    }

    public function getProductByCategory(
        string $slug,
        int $perPage = 20,
        int $page = 1,
        string $sort = 'newest',
        ?string $search = null):  LengthAwarePaginator {

        $category = Category::where('slug', $slug)
            ->select('id')
            ->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->with(['category'])
            ->when($search, function (Builder $query, string $search) {
                $query->where('title', 'like', "%{$search}%");
            });

        $this->applySorting($query, $sort);

        $paginator = $query->paginate(
            perPage: $perPage,
            page: max(1, $page)
        );

        return $paginator->appends(request()->query());
    }

    protected function applySorting(Builder $query, string $sort): void
    {
        switch ($sort) {
            case 'price':
                $query->orderBy('actual_price');
                break;
            case 'popularity':
                $query->orderByDesc('views');
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at')->orderByDesc('id');
                break;
        }

        // Дополнительная сортировка для стабильности пагинации
        $query->orderBy('id');
    }

    public function getNewProducts(int $page = 1, int $limit = 20): LengthAwarePaginator
    {
        try {
            return Product::orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate($limit, ['*'], 'page', $page);
        } catch (\Exception $e) {
            Log::error('ProductService getNewProducts error', [
                'error' => $e->getMessage(),
                'page' => $page,
                'limit' => $limit
            ]);
            throw $e;
        }
    }
}
