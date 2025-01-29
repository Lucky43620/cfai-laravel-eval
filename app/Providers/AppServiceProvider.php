<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Cart;
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
        // Partager le panier pour toutes les vues
        View::composer('*', function ($view) {
            $cart = null;
            if (auth()->check()) {
                // Récupérer le panier de l'utilisateur
                $cart = Cart::where('user_id', auth()->id())->first();
            }

            // Partager la variable $cart dans toutes les vues
            $view->with('cart', $cart);
        });
    }
}
