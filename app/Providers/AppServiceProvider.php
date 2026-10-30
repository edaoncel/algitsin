<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\Category;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Product::observe(ProductObserver::class);

        View::composer('layouts.store', function ($view) {
            $view->with('categories', Category::all());
        });
    }
}