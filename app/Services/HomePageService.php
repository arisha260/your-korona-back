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
            return Product::orderByDesc('views')->take(10)->get();
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

            $products = Product::orderByDesc('created_at')
                ->orderByDesc('id')
                ->take($limit)
                ->get();

            return [
                'data' => $products,
                'nextPage' => $products->count() >= $limit && $products->count() < $maxTotal ? $page + 1 : null,
                'total' => $maxTotal
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
