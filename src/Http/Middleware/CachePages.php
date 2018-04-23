<?php

namespace vvvkor\cms\Http\Middleware;

use Closure;

class CachePages
{

	private function getKey($u){
		if(sizeof(request()->all())>0) return '';//do not cache
		return 'CachePages-'.md5($u);
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		//check cache if not-authorized
		if(!auth()->check()){
			$key = $this->getKey($request->fullUrl());
			if($key && \Cache::has($key)){
				\Log::info('page from cache');
				return response(\Cache::get($key));
			}
		}
        return $next($request);
    }
	
	public function terminate($request, $response)
	{
		//can cache if (not-authorized && 200 (&& public-section))
		if($response->status()==200 && !auth()->check()){
			$timeout = config('cms.cachePagesTimeout',0);
			if($timeout>0){
				$key = $this->getKey($request->fullUrl());
				if ($key && !\Cache::has($key)){
					\Log::info('save page to cache');
					\Cache::put($key, $response->getContent(), $timeout);
				}
			}
		}
	}
}
