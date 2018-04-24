<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Lookup;

class LookupController extends EntityController
{
    
	protected $entity = '';
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
