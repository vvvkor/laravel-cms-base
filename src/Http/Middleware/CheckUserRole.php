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
			return config('cms.page403','')
				? response(view('cms::errors.403', []), 403)
				: abort(403, 'Forbidden');
        }
        return $next($request);
    }
	
}
