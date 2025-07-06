<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;

use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();
        // Truyền 3 danh mục nhiều sản phẩm nhất ra header client
        View::composer('client.layouts.header', function ($view) {
            $topCategories = Category::withCount('products')
                ->orderByDesc('products_count')
                ->take(3)
                ->get();
            $view->with('topCategories', $topCategories);
        });
    }
}
