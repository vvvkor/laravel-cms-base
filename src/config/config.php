<?php

return [

	//nav
	'languages' => ['en'=>'English', 'ru'=>'Русский'],
	'adminEntities' => ['sections','users'/*,'roles','categories'*/],

	//access
	'adminRole' => 'admin', //users.role_id
	'page403' => false, // false:abort(403); true:view('cms::errors.403')

	//cache
	'cachePagesTimeout' => 0, //minutes 1440
	'cacheThumbsTimeout' => 1440, //minutes 1440

	//interface
	'perPage' => 10,
	'perPageFiles' => 100,
	'perPageAdmin' => 20,
	'perPageSubs' => 10,
	
];