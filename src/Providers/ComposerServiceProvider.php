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
            '*', 'Simbamahaba\Upepo\ViewComposers\SettingsComposer'
        );

        View::composer(
            'vendor.upepo.admin.layouts.master', 'Simbamahaba\Upepo\ViewComposers\TablesMenuComposer'
        );

        View::composer(
            'vendor.upepo.admin.layouts.master', 'Simbamahaba\Upepo\ViewComposers\NewOrdersComposer'
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
