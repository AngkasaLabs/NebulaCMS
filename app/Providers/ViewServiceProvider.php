<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\MenuHelper;

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
        // Share menus with all views
        View::composer('theme::*', function ($view) {
            $view->with([
                'headerMenu' => MenuHelper::render('header'),
                'footerMenu' => MenuHelper::render('footer')
            ]);
        });
    }
}
