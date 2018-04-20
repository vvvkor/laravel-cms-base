<?php

if(!function_exists('cms')){
    function cms() {
		return app()->make(vvvkor\cms\Cms::class);
    }
}
