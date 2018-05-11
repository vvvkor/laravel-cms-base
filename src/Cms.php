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
		return ($user && $user->enabled && $user->role_id==config('cms.adminRole','admin'));
	}
	
	public function isReader(){
		$user = auth()->user();
		return ($user && $user->enabled && $user->role_id);
	}
	
	public function nav($lang=''){
		return $this->repo->nav($lang);
	}
	
	public function homeUrl($lang=''){
		return $this->repo->homeUrl($lang);
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
	
	public function translations($path=null){
		return $this->repo->translations($path);
	}
	
	public function excerpt($s,$add=null){
		$r = preg_replace('/([\.\?!]).*$/s','$1',strip_tags($s), -1, $count);
		if($count && $add!==null) $r .= $add;
		return $r;
	}
	
	public function routes(){
		Route::group([
			'middleware' => ['web'],
			//'namespace' => 'vvvkor\cms\Http\Controllers', // anyway it is relative to App\Http\Controllers :(
			], function () {
			$x = '\\vvvkor\\cms\\Http\\Controllers\\';
			$adm = 'admin/';
			foreach(config('cms.adminEntities') as $table){
				$ctrl = studly_case(str_singular($table)).'Controller';
				if(file_exists(app_path('Http/Controllers/').$ctrl.'.php')) $ctrl = '\\App\\Http\\Controllers\\'.$ctrl;
				else $ctrl = $x.$ctrl;
				//Route::get($adm.$table.'/{id}/del', $ctrl.'@confirmDelete');//ask to delete -> @show
				Route::get($adm.$table.'/{id}/unload/{field}', $ctrl.'@unload') //delete uploaded
					->name('admin.'.$table.'.unload')
					->middleware('auth')
					->middleware('vvvkor\cms\Http\Middleware\CheckUserRole');
				Route::get($adm.$table.'/{id}/{do}', $ctrl.'@turn') //turn on/off
					->where('do','on|off')
					->name('admin.'.$table.'.turn')
					->middleware('auth')
					->middleware('vvvkor\cms\Http\Middleware\CheckUserRole');
				Route::group(['as' => 'admin.'], function() use ($adm,$table,$ctrl) {
					Route::resource($adm.$table, $ctrl)
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