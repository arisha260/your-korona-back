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

        try {
            $category = Category::where('slug', $slug)
                ->select('id')
                ->first();

            if (!$category) {
                abort(404, 'Категория не найдена');
            }

            $query = Product::where('category_id', $category->id)
                ->select([
                    'id',
                    'title',
                    'slug',
                    'actual_price',
                    'old_price',
                    'photos',
                    'views',
                    'created_at',
                    'category_id'
                ])
                ->with(['category' => function($query) {
                    $query->select('id', 'name', 'slug');
                }])
                ->when($search, function (Builder $query, string $search) {
                    $query->where('title', 'like', "%{$search}%");
                });

            $this->applySorting($query, $sort);

            return $query->paginate($perPage, ['*'], 'page', max(1, $page))
                ->appends(request()->except('page'));

        } catch (\Exception $e) {
            Log::error('ProductService getProductByCategory error', [
                'error' => $e->getMessage(),
                'slug' => $slug,
                'params' => compact('perPage', 'page', 'sort', 'search')
            ]);
            throw $e;
        }
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
