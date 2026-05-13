<?php

namespace App\Services;

use App\Models\Category;
use App\Models\KoronaNew;
use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomePageService
{
    public function getData(): array
    {
        try {
            return [
                'populars' => $this->getPopularProducts(),
                'lastNews' => $this->getLatestNews(),
                'latestReviews' => $this->getLatestReviews(),
                'newProducts' => $this->getNewProducts(),
                'categories' => $this->getCategories(),
            ];
        } catch (\Exception $e) {
            Log::error('HomePageService failed', ['error' => $e]);
            throw $e;
        }
    }

    protected function getPopularProducts()
    {
        return $this->cache('popular_products', 300, function () {
            return Product::active()->orderByDesc('views')->take(10)->get();
        }, 'Failed to load popular products');
    }

    protected function getLatestNews()
    {
        return $this->cache('latest_news', 1800, function () {
            return KoronaNew::latest()->take(4)->get();
        }, 'Failed to load latest news');
    }

    protected function getLatestReviews()
    {
        return $this->cache('latest_reviews', 1800, function () {
            return KoronaReview::latest()->take(4)->get();
        }, 'Failed to load latest reviews');
    }

    protected function getCategories()
    {
        return $this->cache('categories_all', 86400, function () {
            return Category::all();
        }, 'Failed to load categories');
    }

    protected function getNewProducts(): array
    {
        try {
            $page = 1;
            $limit = 5;
            $maxTotal = 20;

            // Получаем максимум $maxTotal продуктов
            $allProducts = Product::active()
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->take($maxTotal)
                ->get();

            $chunks = $allProducts->chunk($limit);
            $items = $chunks->get($page - 1) ?? collect();

            $nextPage = $page < $chunks->count() ? $page + 1 : null;

            return [
                'data' => $items,
                'nextPage' => $nextPage,
                'hasNextPage' => $nextPage !== null,
                'total' => $allProducts->count(), // если нужно показывать общее число
            ];
        } catch (\Exception $e) {
            Log::error('Failed to load new products', ['error' => $e]);
            return [
                'data' => [],
                'nextPage' => null,
                'total' => 0
            ];
        }
    }

    protected function cache(string $key, int $ttl, \Closure $callback, string $logMessage)
    {
        try {
            return Cache::remember($key, $ttl, $callback);
        } catch (\Exception $e) {
            Log::error($logMessage, ['error' => $e]);
            return [];
        }
    }
}
