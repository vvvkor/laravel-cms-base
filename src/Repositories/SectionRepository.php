<?php

namespace vvvkor\cms\Repositories;
 
use vvvkor\cms\Section;

class SectionRepository {
 
	protected $section;

    public function __construct(Section $section) {
        $this->section = $section;
    }

	public function paginate($perPage = 10, $columns = array('*')){
		return $this->section->paginate($perPage, $columns);
	}
	
	public function model(){
		return 'App\Section';
	}
	
	/*
	public function find($id){
		return $this->section->find($id);
	}
	*/
	
	public function nav(){
		//return DB::table('sections')->where([['e',1],['mode','']])->orderBy('seq')->get()->keyBy('id');
		$r = $this->section->where([['mode','']])->allowed()->bySeq()->get()->keyBy('id');
		foreach($r as $k=>$v) if(isset($v->parent_id) && $v->parent_id)  $r[$v->parent_id]->has_sub = 1;
		return $r;
	}
	
	public function section($path, $fld=null, $by='url'){
		$s = $this->section->where([[$by, ''.$path]])->allowed(1);
		return $fld===null ? $s->first() : $s->value($fld);
	}
	
	public function sectionExists($path, $by='url'){
		$s = $this->section->where([[$by, ''.$path]]);
		return $s ? $s->value('id') : false;
	}
	
	public function articles($id, $per_page=null){
		if($per_page===null) $per_page = config('cms.perPage',10);
		return $id
			? $this->section
				->where([['mode','a'],['parent_id',$id]])
				->allowed()
				->bySeq()
				->paginate($per_page)
				//->get()
				//->keyBy('id')
			: [];
	} 	
	
	public function files($id, $per_page=null){
		if($per_page===null) $per_page = config('cms.perPageFiles',100);
		return $id
			? $this->section
				->where([['mode','f'],['parent_id',$id]])
				->allowed()
				->bySeq()
				->paginate($per_page)
				//->get()
				//->keyBy('id')
			: [];
	} 	
	
	public function subsections($id, $mode='', $per_page=null){
		if($per_page===null) $per_page = config('cms.perPageSubs',10);
		return $id
			? $this->section
				->where([['parent_id',$id],['mode',$mode]])
				->allowed()
				->paginate($per_page)
			: [];
	}
	
	public function translations($path=null){
		if($path===null) $path = request()->path();
		if($path=='/') $path = '';
		$langs = config('cms.languages');
		if((strlen($path)==2 || substr($path,2,1)=='/') && isset($langs[substr($path,0,2)])){
			$lang = substr($path,0,2);
			$path = substr($path,3) ?: '';
		}
		else $lang = config('app.locale');
		//return ['en'=>['url'=>'','name'=>$lang]];
		return $this->section
			->where('url','like',$path ? '__/'.$path : '__')
			->orWhere('url',$path)
			->allowed()
			->matchLangUrl()
			->groupBy('lang')
			->get()
			->keyBy('lang');
	}

	
}