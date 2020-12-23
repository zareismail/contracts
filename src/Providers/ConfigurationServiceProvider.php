<?php

namespace Zareismail\Contracts\Providers;
 
use Illuminate\Support\Facades\Broadcast;
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
        $this->app['config']->set('scout.driver', null);

        $this->mergeConfigFrom(__DIR__.'/../../config/option.php', 'option');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        Broadcast::routes(); 
        
        Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });
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
