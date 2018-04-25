<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Entity;


abstract class EntityController extends CommonController
{
	
	public function __construct(Repo $repo, Entity $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
		//get table name from model class name
		$m = explode('\\', get_class($model));
		$this->entity = str_plural(strtolower(array_pop($m)));
		//or from url
		//$this->entity = request()->segment(2);
		////$this->entity = request()->segment(count(request()->segments()))
	}
	
}
