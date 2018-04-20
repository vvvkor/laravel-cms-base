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
		View::share('lang', app()->getLocale());
		View::share('user', auth()->user());
	}
	
	//custom
	
    public function view($url='')
    {	
		$this->checkUserEnabled();
		$sec = $this->repo->section($url);
		if(!$sec) abort($this->repo->sectionExists($url) ? 403 : 404);
		$r = $this->prepare($sec);
		return $r===null
			? view('cms::page', $this->pageData($sec))
			: $r;
    }
	
	private function checkUserEnabled(){
		$user = auth()->user();
		if($user && !$user->e){
			$this->flash('message-danger', 'auth-locked');
			auth()->logout();
		}
	}

	private function pageData($s){
		//shared: lang, user
		//common
		return [
			//'nav' => $this->repo->nav(),
			'sec' => $s,
			'articles' => $this->repo->articles($s ? $s->id : 0),
			'files' => $this->repo->files($s ? $s->id : 0),
			//'title' => $s->h1,
			];
	} 	

	//set lang, redirect?
	protected function prepare($sec, $preferUserLang=false){
		//user
		$user = auth()->user();
		//set lang
		$lang_sources = $preferUserLang ? [$user, $sec] : [$sec, $user];
		$set_lang = null;
		foreach($lang_sources as $ls) if(!$set_lang && $ls && $ls->lang) $set_lang = $ls->lang;
		if($set_lang) app()->setLocale($set_lang);
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
