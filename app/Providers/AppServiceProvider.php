<?php

namespace App\Providers;

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
        //calculate and display the number of items in the Basket and Wishlist in the header, resolving the "0" or missing counts issue 
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $cartCount = \Illuminate\Support\Facades\DB::table('shopping_basket')->where('user_id', auth()->id())->sum('quantity');
                $wishlistCount = \Illuminate\Support\Facades\DB::table('wishlist')->where('user_id', auth()->id())->count();
            } else {
                $cartCount = 0;
                $wishlistCount = 0;
            }
            $view->with('cartCount', $cartCount)->with('wishlistCount', $wishlistCount);
        });
    }
}
