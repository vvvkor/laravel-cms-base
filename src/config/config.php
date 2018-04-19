<?php

return [

	//access
	'adminRole' => 'admin', //users.role
	'page403' => true, // false:abort(403); true:view('cms::errors.403')

	//cache
	'cachePagesTimeout' => 0, //minutes 1440
	'cacheThumbsTimeout' => 1440, //minutes 1440

	//interface
	'perPage' => 10,
	'perPageFiles' => 100,
	'perPageAdmin' => 20,
	'perPageSubs' => 10,
	
];