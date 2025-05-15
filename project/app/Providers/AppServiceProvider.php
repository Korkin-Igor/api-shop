<?php

namespace App\Providers;

use App\Policies\{
    ProductPolicy,
    CartPolicy,
    CartItemPolicy,
    OrderPolicy,
};
use App\Models\{
    Product,
    Cart,
    CartItem,
    Order
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        Product::class => ProductPolicy::class,
        Cart::class => CartPolicy::class,
        CartItem::class => CartItemPolicy::class,
        Order::class => OrderPolicy::class
    ];

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
        //
    }
}
