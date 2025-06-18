<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
            // توفير $categories لجميع العروض التي تحتوي على nav_links
    View::composer('*', function ($view) {
        $view->with('categories', Category::all());
    });
    }
}
