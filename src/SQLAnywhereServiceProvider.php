<?php

namespace jbalbuena\sqlanywhere;

use Illuminate\Support\ServiceProvider;
use jbalbuena\sqlanywhere\SQLAnywhereConnector as Connector;

class SQLAnywhereServiceProvider extends ServiceProvider
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
        //
        $this->app['db']->extend('sqlanywhere', function($config){
            $connector = new Connector();
            $connection = $connector->connect($config);
            $db = new SQLAnywhereConnection($connection);
            return $db;
        });
    }
}
