<?php
/**
 * Created by PhpStorm.
 * User: wingman
 * Date: 12.11.2015
 * Time: 22:30
 */

namespace Ircop\Antiflood;

use Illuminate\Support\ServiceProvider;

class AntifloodServiceProvider extends ServiceProvider
{
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
        $this->app->singleton('antiflood', function ($app) {
            return new Antiflood;
        });
    }
}