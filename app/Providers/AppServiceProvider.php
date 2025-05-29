<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\KoronaNew;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\NewObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\KoronaNewsPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100)->by($request->user()?->id ?: $request->ip());
        });

        Gate::policy(User::class, AdminPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(KoronaNew::class, KoronaNewsPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);

        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        User::observe(UserObserver::class);
        KoronaNew::observe(NewObserver::class);
    }
}
