<?php

namespace Simbamahaba\Upepo;

use Illuminate\Support\ServiceProvider;
use Simbamahaba\Upepo\Console\Commands\CreateAdminCommand;
use Simbamahaba\Upepo\Providers\EventServiceProvider;
class UpepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if( config('shop.active') === true ) {
            $this->loadRoutesFrom(__DIR__.'/shop_routes.php');
            $this->loadRoutesFrom(__DIR__ . '/Controllers/Customer/routes/auth.php');
        }

        $this->publishes([
            __DIR__.'/assets' => public_path('/assets'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/Mail' => app_path('/Mail'),
        ], 'mail');

        $this->publishes([
            __DIR__.'/Notifications' => app_path('/Notifications'),
        ], 'notifications');

        $this->publishes([
            __DIR__.'/ViewComposers/MenuComposer.php' => app_path('Http/ViewComposers/MenuComposer.php'),
        ], 'menu');

        $this->publishes([
            __DIR__.'/config/shop.php' => config_path('shop.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/config/imagesize.php' => config_path('imagesize.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/Middleware' => app_path('Http/Middleware'),
        ], 'middleware');

        $this->loadViewsFrom(__DIR__.'/Views', 'upepo');

        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/upepo'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/lang', 'upepo');
        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/upepo'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/config/disks.php','filesystems.disks');
        $this->mergeConfigFrom( __DIR__.'/config/auth_guards.php','auth.guards');
        $this->mergeConfigFrom( __DIR__.'/config/auth_providers.php','auth.providers');
        $this->mergeConfigFrom( __DIR__.'/config/auth_passwords.php','auth.passwords');
        $this->mergeConfigFrom( __DIR__.'/config/imagecache_tpl.php','imagecache.templates');
        $this->mergeConfigFrom( __DIR__.'/config/imagecache_paths.php','imagecache.paths');
        $this->mergeConfigFrom( __DIR__.'/config/services_fb.php','services');

        $this->app->register(EventServiceProvider::class);

        if( $this->app->runningInConsole()){
            $this->commands([
                CreateAdminCommand::class,
            ]);
        }
    }
}
