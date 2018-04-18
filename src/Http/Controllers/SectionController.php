<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Section as Section;

class SectionController extends EntityController
{
    
	protected $entity = 'sections';
	protected $lookups = ['sections'=>'name','users'=>'name'];
	
	protected $tableFields  = ['id','url','parent_id','redirect_id','name','h1','e','mode','lang','fnm','seq','pub_dt','owner_id'];
	protected $recFields    = ['url','parent_id','redirect_id','name','h1','e','mode','lang','fnm','body','seq','pub_dt','owner_id'];
	protected $newRecFields = [];
	
	protected $fields = [
		//v:validate='', :save=true, t:type=text, r:relation, u:nullable
		'url' => [
			//'v' => 'required|min:3',
			't' => ''
			],
		'parent_id' => [
			't' => 'select',
			'r' => 'sections',
			'u' => true,
			],
		'name' => [
			],
		'h1' => [
			],
		'e' => [
			't' => 'checkbox'
			],
		'fnm' => [
			't' => 'file'
			],
		'body' => [
			't' => 'textarea'
			],
		'redirect_id' => [
			't' => 'select',
			'r' => 'sections',
			'u' => true,
			],
		'mode' => [
			//'v' => 'max:1',
			't' => 'select',
			'r' => [''=>'section-nav','c'=>'section-post','f'=>'section-file'],
			],
		'seq' => [
			't' => 'number'
			],
		'lang' => [
			],
		'pub_dt' => [
			't' => 'datetime-local'
			],
		'owner_id' => [
			't' => 'select',
			'r' => 'users',
			'u' => true,
			],
		];


	public function __construct(Repo $repo, Section $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
   	}
	
}
