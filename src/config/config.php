<?php

return [

	//nav
	'languages' => ['en'=>'English', 'ru'=>'Русский', 'es'=>'Español'],
	'adminEntities' => ['sections','users','roles','modes'],

	//access
	'adminRole' => 'a', //users.role
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