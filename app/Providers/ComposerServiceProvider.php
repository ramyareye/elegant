<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // You can use a class for composer
        // you will need NavComposer@compose method
        // which will be called everythime partials.nav is requested
        View::composer(
            'front.partials.home.nav', 'App\Http\Composers\Home\MenuComposer'
        );

        View::composer(
            'front.partials.blog.nav', 'App\Http\Composers\Blog\MenuComposer'
        );

        View::composer(
            'front.blog.sidebars.side-menu', 'App\Http\Composers\Blog\SideMenuComposer'
        );

        View::composer(
            'front.partials.blog.footer', 'App\Http\Composers\Blog\FooterComposer'
        );

        // View::composer('front.partials.home.nav', function ($view) {
        //     $view->with('menu', ['some-menus']);
        // });

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
