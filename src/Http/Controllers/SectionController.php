<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Section as Section;

class SectionController extends EntityController
{
    
	protected $entity = 'sections';
	protected $lookups = ['sections'=>'name','users'=>'name'];
	
	protected $fields = [
		//v:validate='', :save=true, t:type=text, r:relation, u:nullable
		[
		'n' => 'url',
		//'v' => 'required|min:3',
		't' => ''
		],
		[
		'n' => 'parent_id',
		't' => 'select',
		'r' => 'sections',
		'u' => true,
		],
		[
		'n' => 'name',
		],
		[
		'n' => 'h1',
		],
		[
		'n' => 'e',
		't' => 'checkbox'
		],
		[
		'n' => 'fnm',
		't' => 'file'
		],
		[
		'n' => 'body',
		't' => 'textarea'
		],
		[
		'n' => 'redirect_id',
		't' => 'select',
		'r' => 'sections',
		'u' => true,
		],
		[
		'n' => 'mode',
		//'v' => 'max:1',
		't' => 'select',
		'r' => [''=>'section-nav','c'=>'section-post','f'=>'section-file'],
		],
		[
		'n' => 'seq',
		't' => 'number'
		],
		[
		'n' => 'lang',
		],
		[
		'n' => 'pub_dt',
		't' => 'datetime-local'
		],
		[
		'n' => 'owner_id',
		't' => 'select',
		'r' => 'users',
		'u' => true,
		],
		];


	public function __construct(Repo $repo, Section $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
   	}
	
}
