<?php

namespace App\Services\adminProducts;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ProductsService
{

    public function getProducts
    (
        int $perPage = 20,
        int $page = 1,
        ?string $categorySlug = null,
        string $archiveFilter = 'active',
        ?string $search = null
    ):  LengthAwarePaginator
    {

        try {

            $query = Product::query()
                ->select([
                    'id', 'title', 'slug', 'actual_price', 'old_price',
                    'preview', 'category_id', 'is_archived', 'created_at'
                ]);

            if ($categorySlug) {
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                }
            }

            if ($search) {
                $query->where('title', 'like', "%{$search}%");
            }


            $this->applyArchiveFilter($query, $archiveFilter);

            $query->orderBy('created_at', 'desc');

            return $query->paginate($perPage, ['*'], 'page', max(1, $page))
                ->appends(request()->except('page'));

        } catch (\Exception $e) {
            Log::error('ProductService getProductByCategory error', [
                'error' => $e->getMessage(),
                'params' => compact('perPage', 'page', 'categorySlug', 'archiveFilter', 'search')
            ]);
            throw $e;
        }
    }

    protected function applyArchiveFilter(Builder $query, string $filter): void
    {
        match ($filter) {
            'active' => $query->active(),
            'archived' => $query->archived(),
            'all' => null,
            default => $query->active(),
        };
    }

}
