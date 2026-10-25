<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- BU SATIRI EKLERDİĞİNİZDEN EMİN OLUN
use App\Models\Category;

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
        View::composer('*', function ($view) {
            if (!request()->is('yonetim*') && !request()->is('admin*')) {
                $view->with('categories', Category::all());
            }
        });
    }
}