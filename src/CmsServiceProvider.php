<?php

namespace vvvkor\cms;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; //to use $policies
//use Illuminate\Routing\Router;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\Facades\Route; 
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
    }
	
    private function registerCms()
    {
        $this->app->singleton('Cms',function($app){ //bind OR singleton
            return new Cms($app);
        });
    }
	
	
	/*
	// manual routes: include line in routes.php:
	// \vvvkor\cms\CmsServiceProvider::routes();
	public static function routes()
    {
		
		Route::group(['middleware' => ['web']], function () {
			$x = '\\vvvkor\\cms\\Http\\Controllers\\';
			$res = array(
				'sections' => $x.'SectionController',
				'users' => $x.'UserController',
				);
			$adm = 'admin/';
			foreach($res as $k=>$v){ 
				//Route::get($adm.$k.'/{id}/del', $v.'@confirmDelete');//ask to delete -> @show
				Route::get($adm.$k.'/{id}/unload/{field}', $v.'@unload')->middleware('auth');//delete uploaded
				Route::resource($adm.$k, $v)->middleware('auth');
			}
			
			Route::get('/',$x.'PageController@view')->where('sec','.*')->name('start')->middleware('vvvkor\cms\Http\Middleware\CachePages');
			Route::get('download/{entity}/{id}/{filename?}',$x.'DownloadController@download')->name('download');
			Route::get('getfile/{entity}/{id}/{width?}/{height?}/{filename?}',$x.'DownloadController@getfile')->name('getfile');
			Route::get('{url}',$x.'PageController@view')->where('url','.*')->name('front')->middleware('vvvkor\cms\Http\Middleware\CachePages');
		});
    }
	*/
}