<?php

namespace vvvkor\cms\Http\Controllers;

class CategoryController extends EntityController
{
    
	protected $uniques = ['id'];
	protected $tabFields  = ['id','name','seq'];
	protected $recFields    = ['name','seq'];
	protected $newRecFields    = ['name','seq'];
	
	protected $fields = [
		'id' => [
			'v' => 'required',
			],
		'name' => [
			'v' => 'required',
			],
		'seq' => [
		],
		];

} 