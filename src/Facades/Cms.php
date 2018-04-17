<?php

namespace vvvkor\cms\Facades;
use Illuminate\Support\Facades\Facade;

class Cms extends Facade{
	
    protected static function getFacadeAccessor(){
		return 'Cms';
	}
	
}