<?php

namespace Zareismail\Contracts\Providers;
 
use Illuminate\Support\ServiceProvider;  

class ConfigurationServiceProvider extends ServiceProvider 
{   
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['config']->set('logging.default', 'daily');

        $this->mergeConfigFrom(__DIR__.'/../../config/option.php', 'option');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { 
    } 
}
