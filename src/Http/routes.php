<?php

	//namespace vvvkor\cms;

	//use vvvkor\cms\Http\Controllers\PageController;
	//use vvvkor\cms\Http\Controllers\UserController;
	//use vvvkor\cms\Http\Controllers\SectionController;
	//use vvvkor\cms\Http\Controllers\DownloadController;

Route::group(['middleware' => ['web']], function () {
	$res = array(
		'sections' => 'SectionController',
		'users' => 'UserController',
		);
	$adm = 'admin/';
	foreach($res as $k=>$v){ 
		//Route::get($adm.$k.'/{id}/del', $v.'@confirmDelete');//ask to delete -> @show
		Route::get($adm.$k.'/{id}/unload/{field}', $v.'@unload')->middleware('auth');//delete uploaded
		Route::resource($adm.$k, $v)->middleware('auth');
	}
	
	Route::get('/','PageController@view')->where('sec','.*')->name('start')->middleware('vvvkor\cms\Http\Middleware\CachePages');
	Route::get('download/{entity}/{id}/{filename?}','DownloadController@download')->name('download');
	Route::get('getfile/{entity}/{id}/{width?}/{height?}/{filename?}','DownloadController@getfile')->name('getfile');
	Route::get('{url}','PageController@view')->where('url','.*')->name('front')->middleware('vvvkor\cms\Http\Middleware\CachePages');
});