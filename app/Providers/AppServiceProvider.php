<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
    public function boot()
    {
        Schema::defaultStringLength(191);


        \View::composer('*', function($view) {
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });

            $view->with('channels', $channels);
        });

        \Validator::extend('spamFree', 'App\Rules\SpamFree@passes');
    }
}
