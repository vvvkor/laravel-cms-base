<?php

namespace vvvkor\cms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Facades\Cms;

class PageController extends Controller
{
	
	protected $repo;
	
	public function __construct(Repo $repo){
		$this->repo = $repo;
		$this->middleware(function ($request, $next) {
            $this->share();
            return $next($request);
        });

	}
	
	protected function share(){
		View::share('user', auth()->user());
		View::share('admin', Cms::isAdmin());
		View::share('lang', app()->getLocale());
	}
	
	//custom
	
    public function view($url='')
    {
		$sec = $this->repo->section($url);
		if(!$sec) abort(404);
		$r = $this->prepare($sec);
		return $r===null
			? view('cms::page', $this->pageData($sec))
			: $r;
    }

	private function pageData($s){
		//shared: lang, user
		//common
		return [
			'nav' => $this->repo->nav(),
			'sec' => $s,
			'articles' => $this->repo->articles($s ? $s->id : 0),
			'files' => $this->repo->files($s ? $s->id : 0),
			//'title' => $s->h1,
			];
	} 	

	//set lang, redirect?
	protected function prepare($sec){
		//user
		$user = auth()->user();
		//set lang
		if($sec && $sec->lang){
			app()->setLocale($sec->lang);
		}
		else if($user && $user->lang){
			app()->setLocale($user->lang);
		}
		//redirect?
		if($sec && $sec->redirect_id){
			$to = $this->repo->section($sec->redirect_id, 'url', 'id');
			if($to!==null) return redirect()->route('page', ['sec' => $to]);
		}
		$this->share();
		return null;
	}
	
	//helpers
	
	protected function flash($k, $s, $e=null){
		session()->flash($k, array_merge((array)session()->get($k), array($s)));		
		if($e && config('app.debug')) $this->flash($k, ' '.$e->getMessage());
	}
	
}
