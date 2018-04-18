<?php

namespace vvvkor\cms\Http\Middleware;

use Closure;
use vvvkor\cms\Facades\Cms;

class CheckUserRole
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
		if($user && $user->lang) app()->setLocale($user->lang);
        if(!Cms::isAdmin()){
			//$this->flash('403');
			//return back()->withInput();
			//return redirect('/');
			//return abort(403, 'Not admin');
			return response(view('cms::errors.403', [
				'user' => $user,
				'lang' => app()->getLocale(),
				'title' => __('cms::common.forbidden'),
				]), 403);
        }
        return $next($request);
    }
	
}
