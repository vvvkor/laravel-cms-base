<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Section as Section;

class SectionController extends EntityController
{
    
	protected $entity = 'sections';
	protected $lookups = ['sections'=>'name','users'=>'name'];
	
	protected $tabFields  = ['id','url','parent_id','redirect_id','name','h1','e','mode','lang','fnm','seq','pub_dt','owner_id'];
	protected $subTabFields  = ['id','url','name','e'];
	protected $recFields    = ['url','parent_id','redirect_id','name','h1','e','mode','lang','fnm','body','seq','pub_dt','owner_id'];
	protected $newRecFields = [];
	
	protected $fields = [
		//v:validate='', :save=true, t:type=text, r:relation|[], u:nullable,
		//x:skip_in_query
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
			'r' => ['','a','f'],
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
	
	
	public function aside($rec){
		$d = $this->repo->subsections($rec->id);
		if($d->count()==0) return 'No subsections';
		//$cols = $this->db->getSchemaBuilder()->getColumnListing('sections');
		
		/*
		return view('cms::sectree', [
			'nav' => $this->repo->nav(),
			'root' => $rec->id
			]);
		*/
		return view('cms::table', [
			'aside' => 1,
			'model' => 'vvvkor\cms\Section',
			'table' => 'sections',
			'columns' => $this->tableFields(1),
			'records' => $d,
			'nav' => $d, //$this->repo->nav(), //for tree
			'root' => $rec->id, //for tree
			]);
	}

}
