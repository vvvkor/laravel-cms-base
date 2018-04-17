<?php

namespace vvvkor\cms;

use Illuminate\Support\Facades\Route;

class Cms{
	
	public function routes(){
		Route::group([
			'middleware' => ['web'],
			//'namespace' => 'vvvkor\cms\Http\Controllers', // anyway it is relative to App\Http\Controllers :(
			], function () {
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
	
}