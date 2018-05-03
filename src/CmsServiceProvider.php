<?php

namespace vvvkor\cms;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; //to use $policies
//use Illuminate\Routing\Router;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\Facades\Route; 
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Models\Section;
use vvvkor\cms\Cms;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		'App\User' => 'vvvkor\cms\Policies\UserPolicy',
		'vvvkor\cms\Models\Section' => 'vvvkor\cms\Policies\SectionPolicy',
		//'vvvkor\cms\Role' => 'vvvkor\cms\Policies\RolePolicy',
		//'vvvkor\cms\Mode' => 'vvvkor\cms\Policies\ModePolicy',
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
		// BUT this overrides Auth routes, so Facade is used instead
        //$this->setupRoutes($this->app->router);
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
		
		$this->registerPolicies();

		$this->loadMigrationsFrom(__DIR__.'/migrations');

	    if ($this->app->runningInConsole()) {
			$this->commands([
				Console\CmsMakeCommand::class,
			]);
		}

    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
	/*
    public function setupRoutes(Router $router)
    {
		//auto routes
        $router->group(['namespace' => 'vvvkor\cms\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }
	*/
	
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
		$this->registerCms();
		
		// register controllers
		$this->app->make('vvvkor\cms\Http\Controllers\PageController');
		$this->app->make('vvvkor\cms\Http\Controllers\SectionController');
		$this->app->make('vvvkor\cms\Http\Controllers\DownloadController');
		

		//merge user config with default config
		$this->mergeConfigFrom(
			__DIR__.'/config/config.php', 'cms'
		);
		
		//use contextual binding to inject models
 		foreach(config('cms.adminEntities') as $table){
			$name = studly_case(str_singular($table));
			
			//for controllers:
			//models from package
			$this->app->when('vvvkor\cms\Http\Controllers\\'.$name.'Controller')
				->needs('vvvkor\cms\Models\Entity')
				->give('vvvkor\cms\Models\\'.$name);
			//models from app
			$this->app->when('App\Http\Controllers\\'.$name.'Controller')
				->needs('vvvkor\cms\Models\Entity')
				->give('App\Models\\'.$name);

			/*
			//for policies:
			//models from package
			$this->app->when('vvvkor\cms\Policies\\'.$name.'Policy')
				->needs('vvvkor\cms\Models\Entity')
				->give('vvvkor\cms\\'.$name);
			//models from app
			$this->app->when('App\Policies\\'.$name.'Policy')
				->needs('vvvkor\cms\Models\Entity')
				->give('App\\'.$name);
			*/
			
			/*
			//$this->app->when('vvvkor\cms\Http\Controllers\\'.$name.'Controller')
			//$this->app->when('vvvkor\cms\\'.$name)
				->needs('vvvkor\cms\EntityPolicy')
				->give('vvvkor\cms\Policies\\'.$name.'Policy');
			*/
		}

   }
	
    private function registerCms()
    {
        $this->app->singleton('Cms',function($app){ //bind OR singleton
            return new Cms(new Repo(new Section()));
        });
		require_once 'helpers.php';
    }
	
	
	/*
	// manual routes: include line in routes.php:
	// \vvvkor\cms\CmsServiceProvider::routes();
	public static function routes()
    {
		
		Route::group(...);
		Route::get(...);
    }
	*/
}