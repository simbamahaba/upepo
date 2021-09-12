<?php

namespace Simbamahaba\Upepo\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*View::composer(
            'layouts.app', 'App\Http\ViewComposers\MenuComposer'
        );*/

        View::composer(
            '*', 'Decoweb\Panelpack\ViewComposers\SettingsComposer'
        );

        View::composer(
            'vendor.decoweb.admin.layouts.master', 'Decoweb\Panelpack\ViewComposers\TablesMenuComposer'
        );

        View::composer(
            'vendor.decoweb.admin.layouts.master', 'Decoweb\Panelpack\ViewComposers\NewOrdersComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
