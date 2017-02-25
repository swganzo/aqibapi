<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
      $view->composer('layouts.app', 'App\Http\ViewComposers\GlobalComposer');
        //
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
// https://laracasts.com/discuss/channels/general-discussion/l5-service-provider-for-sharing-view-variables
