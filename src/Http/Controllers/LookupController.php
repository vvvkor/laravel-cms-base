<?php

namespace vvvkor\cms\Http\Controllers;

class LookupController extends EntityController
{
    
	protected $uniques = ['id'];
	protected $tabFields  = ['id','name'];
	protected $recFields    = ['name'];
	protected $newRecFields    = ['id','name'];
	
	protected $fields = [
		'id' => [
			'v' => 'required',
			],
		'name' => [
			'v' => 'required',
			],
		];

}
