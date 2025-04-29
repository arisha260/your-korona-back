<?php

namespace App\Services;

use App\Models\Category;
use App\Models\KoronaNew;
use App\Models\KoronaReview;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class HomePageService
{
//    public function getData(): array
//    {
//        return [
//            'populars' => Product::orderByDesc('views')->take(10)->get(),
//            'lastNews' => KoronaNew::latest()->take(4)->get(),
//            'latestReviews' => KoronaReview::latest()->take(4)->get(),
//            'newProducts' => $this->getNewProducts(),
//            'categories' => Category::all(),
//        ];
//    }

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

    protected function getNewProducts(): array
    {
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
    }

    protected function getPopularProducts()
    {
        try {
            return Product::orderByDesc('views')->take(10)->get();
        } catch (\Exception $e) {
            Log::error('Failed to load popular products', ['error' => $e]);
            return [];
        }
    }

    protected function getLatestNews()
    {
        try {
            return KoronaNew::latest()->take(4)->get();
        } catch (\Exception $e) {
            Log::error('Failed to load latest news', ['error' => $e]);
            return [];
        }
    }

    protected function getLatestReviews()
    {
        try {
            return KoronaReview::latest()->take(4)->get();
        } catch (\Exception $e) {
            Log::error('Failed to load latest reviews', ['error' => $e]);
            return [];
        }
    }

    protected function getCategories()
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            Log::error('Failed to load categories', ['error' => $e]);
            return [];
        }
    }
}
