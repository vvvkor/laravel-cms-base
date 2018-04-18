<?php

namespace vvvkor\cms\Services;

use vvvkor\cms\Repositories\SectionRepository as Repo;
//use Illuminate\Database\DatabaseManager;

class RecordService{
	
	//protected $model = null;
	protected $section;
	//protected $db;

	/*
	function __construct(\vvvkor\cms\Section $model){
		$this->model = $model;
	}
	*/

	function __construct(/*DatabaseManager $db,*/ Repo $section){
		//$this->db = $db;
		$this->section = $section;
	}
	
	public function subSections($table, $id, $layout){
		if($table=='sections'){
			$d = $this->section->subsections($id);
			//$d = $this->model->where('parent_id',$id)->paginate(config('cms.perPageSubs',20));
			if($d->count()==0) return 'No subsections';
			//$cols = $this->db->getSchemaBuilder()->getColumnListing('sections');
			$cols = ['id'=>['l'=>'id'],'nm'=>['l'=>'name'],'url'=>['l'=>'url']];
			return view($layout, [
				'aside' => 1,
				'model' => 'vvvkor\cms\Section',
				'table' => 'sections',
				'columns' => $cols,
				'records' => $d
				]);
		}
	}
}