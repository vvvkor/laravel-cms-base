<?php

namespace vvvkor\cms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use vvvkor\cms\Repositories\SectionRepository as Repo;

class Cms{
	
	protected $repo;
	
	public function __construct(Repo $repo){
		$this->repo = $repo;
	}
	
	public function isAdmin(){
		$user = auth()->user();
		return ($user && $user->e && $user->role==config('cms.adminRole','admin'));
	}
	
	public function isReader(){
		$user = auth()->user();
		return ($user && $user->e && $user->role);
	}
	
	public function nav(){
		return $this->repo->nav();
	}
	
	public function section($path, $fld=null, $by='url'){
		return $this->repo->section($path, $fld, $by);
	}
	
	public function recName($t, $id, $fld='name'){
		//return $this->repo->section($id, 'name', 'id');
		return $id
			?
			//very naive caching
			Cache::remember(/*auth()->user()->id.'#'.*/ 'rec-'.$t.'-'.$id.'-'.$fld, 
				.1, //timeout, minutes
				function() use ($t, $id, $fld){
					return DB::table($t)->where('id',$id)->value($fld);
				})
			: null;
			
	}
	
	public function excerpt($s/*,$u=null*/){
		return preg_replace('/([\.\?!]).*$/s','$1',strip_tags($s) /*, -1, $count*/);
		//if($count && $u!==null) $r .= '...';
		//return $r;
	}
	
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
				Route::get($adm.$k.'/{id}/unload/{field}', $v.'@unload') //delete uploaded
					->name('admin.'.$k.'.unload')
					->middleware('auth')
					->middleware('vvvkor\cms\Http\Middleware\CheckUserRole');
				Route::get($adm.$k.'/{id}/{do}', $v.'@turn') //turn on/off
					->where('do','on|off')
					->name('admin.'.$k.'.turn')
					->middleware('auth')
					->middleware('vvvkor\cms\Http\Middleware\CheckUserRole');
				Route::group(['as' => 'admin.'], function() use ($adm,$k,$v) {
					Route::resource($adm.$k, $v)
						->middleware('auth')
						->middleware('vvvkor\cms\Http\Middleware\CheckUserRole');
				});
			}
			Route::resource('profile',$x.'ProfileController')->middleware('auth');
			Route::get('/',$x.'PageController@view')->name('start')->middleware('vvvkor\cms\Http\Middleware\CachePages');
			Route::get('download/{entity}/{id}/{filename?}',$x.'DownloadController@download')->name('download');
			Route::get('getfile/{entity}/{id}/{width?}/{height?}/{filename?}',$x.'DownloadController@getfile')->name('getfile');
			Route::get('{url}',$x.'PageController@view')->where('url','.*')->name('page')->middleware('vvvkor\cms\Http\Middleware\CachePages');
			//Route::get('{url}',function(){ return 'test'; })->where('url','.*')->name('page')->middleware('vvvkor\cms\Http\Middleware\CachePages');
		});
    }
	
}