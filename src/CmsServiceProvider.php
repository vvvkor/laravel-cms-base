<?php

namespace vvvkor\cms;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		'App\User' => 'vvvkor\cms\Policies\UserPolicy',
		'vvvkor\cms\Section' => 'vvvkor\cms\Policies\SectionPolicy',
	];
	
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
	
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
		$this->registerPolicies();
		
        // use this if your package has views
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'cms');
		$this->publishes([
			__DIR__.'/resources/views' => resource_path('views/vendor/cms'),
		]);
        
        // use this if your package has lang files
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'cms');
		$this->publishes([
			__DIR__.'/resources/lang' => resource_path('lang/vendor/cms'),
		]);
        
        // use this if your package has routes
        $this->setupRoutes($this->app->router);
		//OR
		//$this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        
        // use this if your package needs a config file
        $this->publishes([
			__DIR__.'/config/config.php' => config_path('cms.php'),
        ]);
        
        // use the vendor configuration file as fallback
        // $this->mergeConfigFrom(
        //     __DIR__.'/config/config.php', 'cms'
        // );
		

		$this->loadMigrationsFrom(__DIR__.'/migrations');
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'vvvkor\cms\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerCms();

		// register controllers
		$this->app->make('vvvkor\cms\Http\Controllers\PageController');
		$this->app->make('vvvkor\cms\Http\Controllers\SectionController');
		$this->app->make('vvvkor\cms\Http\Controllers\DownloadController');
		
	
        // use this if your package has a config file
		/*
         config([
                 __DIR__.'/config/config.php',
         ]);
		 */
		$this->mergeConfigFrom(
			__DIR__.'/config/config.php', 'cms'
		);
    }
	/*
    private function registerCms()
    {
        $this->app->bind('cms',function($app){
            return new Cms($app);
        });
    }
	*/
}