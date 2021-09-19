<?php

namespace Simbamahaba\Upepo\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Models\Category;
class ShopServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Simbamahaba\Upepo\Helpers\Contracts\ShopContract', function(){
//            return new \App\Helpers\Shop(new Category(), new Product());
            return new \Simbamahaba\Upepo\Helpers\Shop(new Category(), new Product());
        });

    }

    public function provides()
    {
        return ['Simbamahaba\Upepo\Helpers\Contracts\ShopContract'];
    }
}
