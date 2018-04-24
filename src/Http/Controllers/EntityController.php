<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Entity;


abstract class EntityController extends CommonController
{
	
	public function __construct(Repo $repo, Entity $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
	}
	
}
