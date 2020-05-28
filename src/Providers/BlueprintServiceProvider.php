<?php

namespace Zareismail\Contracts\Providers;
 
use Illuminate\Support\ServiceProvider; 
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Schema\Blueprint;

class BlueprintServiceProvider extends ServiceProvider implements DeferrableProvider
{  
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // The user authentication.
        Blueprint::macro('auth', function($auth = 'auth') {
            $this->foreignId("{$auth}_id")->constrained('users'); 
        });

        Blueprint::macro('dropAuth', function($auth = 'auth') {
            $this->dropForeign("{$auth}_id");
            $this->dropColumn("{$auth}_id"); 
        }); 

        // The resource details.
        Blueprint::macro('detail', function() {
            $this->json("detail")->default('[]');
        });

        Blueprint::macro('dropDetail', function() { 
            $this->dropColumn('detail'); 
        });

        // The resource configurations.
        Blueprint::macro('config', function() {
            $this->json("config")->default('[]');
        });

        Blueprint::macro('dropConfig', function() { 
            $this->dropColumn('config'); 
        });

        // The user authentication.
        Blueprint::macro('labeling', function($label = 'label') {
            return $this->string($label)->nullable(); 
        });

        Blueprint::macro('dropLabeling', function($label = 'label') { 
            $this->dropColumn($label); 
        });

        // The user authentication.
        Blueprint::macro('naming', function() {
            return $this->labeling('name'); 
        }); 
 
        Blueprint::macro('dropNaming', function() {
            $this->dropLabeling('name'); 
        }); 

        // The user authentication.
        Blueprint::macro('slugging', function($name = 'name') {
            $this->naming($name); 
            $this->string('slug')->nullable()->index(); 
        });  
 
        Blueprint::macro('dropSlugging', function($name = 'name') {
            $table->dropIndex('slug');
            $table->dropColumn('slug');
            $this->dropNaming($name); 
        }); 

        // The user authentication.
        Blueprint::macro('url', function() { 
            return $this->string('url', 1024)->nullable()->index(); 
        });   
 
        Blueprint::macro('dropUrl', function() {
            $table->dropIndex('url');
            $table->dropColumn('url');  
        });

        // Price blueprint
        Blueprint::macro('price', function($name = 'price', $total = 10, $places = 2) {
            return $this->double($name, $total, $places)->default(0.00); 
        });

        Blueprint::macro('dropPrice', function($name = 'price') {
            $this->dropColumn($name);
        });

         // small price blueprint
        Blueprint::macro('smallPrice', function($name = 'price') {
            return $this->price($name, 8, 2); 
        });

        Blueprint::macro('dropSmallPrice', function($name = 'price') {
            $this->dropColumn($name);
        });

         // long price blueprint
        Blueprint::macro('longPrice', function($name = 'price') {
            return $this->price($name, 14, 2); 
        });

        Blueprint::macro('dropLongPrice', function($name = 'price') {
            $this->dropColumn($name);
        });

         // google map blueprint
        Blueprint::macro('coordinates', function() {
            $this->string('latitude')->nullable();
            $this->string('longitude')->nullable();  
        });

        Blueprint::macro('dropCoordinates', function() {
            $this->dropColumn(['latitude', 'longitude']);
        }); 

        // SEO blueprint 
        Blueprint::macro('seo', function() {
            return $this->json('seo')->default(json_encode([
                'description' => null,
                'keywords'  => null,
                'robots'    => 'index,follow',
                'title'     => null,
            ]));
        });

        Blueprint::macro('dropSeo', function() {
            $this->dropColumn('seo');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [
            'migrator'
        ];
    }
}
