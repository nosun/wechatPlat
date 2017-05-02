<?php

namespace Share\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*', 'Share\Http\ViewComposers\CommonComposer');
        View::composer('parts.link-header', 'Share\Http\ViewComposers\LinkHeaderComposer');
        View::composer('parts.link-footer', 'Share\Http\ViewComposers\LinkFooterComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
