<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use vvvkor\cms\Repositories\SectionRepository as Repo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\View;
use Illuminate\Http\File;

abstract class EntityController extends PageController
{
	
	protected $entity = 'sections';
	protected $nmf = 'name';
	protected $lookups = [];
	protected $fields = [];
	protected $tabFields  = [];
	protected $subTabFields  = [];
	protected $recFields    = [];
	protected $newRecFields = [];
	
	protected $repo;
	protected $model;
	protected $db;

	protected $modelClass;
	
	public function __construct(Repo $repo, Model $model, DatabaseManager $db){
		$this->repo = $repo;
		$this->model = $model;
		$this->db = $db;
		$this->modelClass = get_class($model);//for controllers
        //$this->authorizeResource($this->model);
		
		//$this->share();
		$this->middleware(function ($request, $next) {
			//redirect?
            $redir = $this->prepare($this->repo->section(request()->path()), true);
			if($redir) return $redir;
			//prepare fields
			foreach($this->fields as $k=>$v){
				$this->fields[$k]['l'] = __('cms::db.'.$this->entity.'-'.$k);
				if(isset($this->fields[$k]['r']) && is_array($this->fields[$k]['r'])){
					/*
					$this->fields[$k]['r'] = array_map(
						function($v){ return __('cms::list.'.$v); },
						$this->fields[$k]['r']
					);
					*/
					$r = array();
					foreach($this->fields[$k]['r'] as $q){
						$r[$q] = __('cms::list.'.$this->entity.'-'.$k.'-'.$q);
					}
					$this->fields[$k]['r'] = $r;
				}
			}
			//session vars
			if(isset($request->view)){
				$key = 'view-'.$this->entity.($request->tag ? '-'.$request->tag : '');
				session([$key => $request->view]);
			}
            return $next($request);
        });

	}
	
	protected function share(){
		parent::share();
		View::share('canCreate', auth()->user()->can('create',$this->modelClass));
	}
	
	//actions
	
    public function index(Request $request)
    {
		$this->authorize('index', $this->modelClass);
		//$cols = $this->db->getSchemaBuilder()->getColumnListing($this->entity);
		$d = $this->model->paginate(config('cms.perPageAdmin',20));
		return view('cms::page-table', [
			'title' => __('cms::db.'.$this->entity),
			//'columns' => $cols,
			'columns' => $this->tableFields(0),
			'records' => $d,
			] + 
			$this->data()
			);
	}

    public function create()
    {
		$this->authorize('create',$this->modelClass);
        return view('cms::page-record', [
			'title' => __('cms::db.'.$this->entity).' - '.__('cms::common.add'),
			'fields' => $this->formFields(1),
			] 
			+ $this->data() 
			+ $this->lookupData()
			);
    }

    public function store(Request $request)
    {
		$this->authorize('create',$this->modelClass);
        $request->validate($this->validatedFields(1));
        
		try{
			$d = $this->preparePosted($request);
			$rec = $this->model->create($d);
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-create', $e);
			return redirect(route('admin.'.$this->entity.'.create'));
		}
		$this->flash('message-success', 'ok-create');
		$this->upload($request, $rec);
        return redirect(route('admin.'.$this->entity.'.edit',['id'=>$rec->id]));
	}

    public function show($id='')
	{
		//$rec = $this->model->findOrFail($id);
		//$this->authorize('view', $rec);
		//return $id;
		return $this->confirmDelete($id);
	}
	
    public function edit($id)
    {
		$rec = $this->model->findOrFail($id);
		$this->authorize('update', $rec);
		return view('cms::page-record', [
			'title' => __('cms::db.'.$this->entity).' - '.__('cms::common.edit').
				' #'.$rec->id, //.' - '.$rec->name
			'fields' => $this->formFields(),
			'rec' => $rec,
			'sec' => $rec,
			'aside' => $this->aside($rec),
			] 
			+ $this->data() 
			+ $this->lookupData()
			);
	}
	
    public function update(Request $request, $id)
    {
        $request->validate($this->validatedFields(0));
        $rec = $this->model->findOrFail($id);
		$this->authorize('update', $rec);
        $s = $this->preparePosted($request, $rec);
		try{
			$rec->save();
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-save', $e);
			return redirect(route('admin.'.$this->entity.'.edit',$id));
		}
		//$request->session()->flash('message-success', 'Saved');
		$this->flash('message-success', 'ok-save');
		$this->upload($request, $rec);
        return redirect(route('admin.'.$this->entity.'.edit',['id'=>$rec->id]));
    }
	
    public function destroy($id)
    {
		$rec = $this->model->findOrFail($id);
		$this->authorize('delete', $rec);
		try{
			$this->model->destroy($id);
		}
		//catch (\Exception $e){
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-delete', $e);
			return redirect(route('admin.'.$this->entity.'.index'));
		}
 		$this->flash('message-success','ok-delete');
        return redirect(route('admin.'.$this->entity.'.index'));
    }
	
	//custom actions

    public function confirmDelete($id)
    {
		$rec = $this->model->findOrFail($id);
		$this->authorize('delete', $rec);
        return view('cms::page-delete', [
			'title' => __('cms::db.'.$this->entity).' - '.__('cms::common.delete').
				' #'.$rec->id, //.' - '.$rec->name,
			'rec' => $rec,
			] 
			+ $this->data()
			);

	}

   public function unload($id,$field){
		$rec = $this->model->findOrFail($id);
		$this->authorize('update', $rec);
		try{
			$fuid = $this->fuid($field);
			$del = $rec->$fuid;
			$rec->$field = '';
			$rec->$fuid = '';
			$rec->save();
			if($del) $this->delFiles($del,1);
			$this->flash('message-success','ok-unload');
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger','fail-unload');
		}
        return redirect(route('admin.'.$this->entity.'.edit',['id'=>$rec->id]));
	}

	public function turn($id, $do){
		$rec = $this->model->findOrFail($id);
		$this->authorize('update', $rec);
		try{
			if($do=='on') $rec->e = 1;
			else if($do=='off') $rec->e = 0;
			else return null;
			$rec->save();
			$this->flash('message-success','ok-save');
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger','fail-save');
		}
        //return redirect(route('admin.'.$this->entity.'.edit',['id'=>$rec->id]));
        return back();//redirect(route('admin.'.$this->entity.'.index'));
	}
	
	//helpers
	
	//@@
	protected function delFiles($del, $thumbs=0){
		if($del){
			Storage::delete($del);
			/*
			if($thumbs){
				if(!is_array($del)) $del = [$del];
				foreach($del as $d){
					$mask = storage_path('app/'.strrev(preg_replace('/\./','.*',strrev($d),1)));
					foreach(glob($mask) as $f) unlink($f);
					//foreach(glob($mask) as $f) Storage::delete($del);
				}
			}
			*/
		}
	}

	protected function data(){
		return [
			//admin
			'table' => $this->entity, // subs, attach ...
			'nmf' => $this->nmf, // hints
			//'canCreate' => auth()->user()->can('create', $this->modelClass), //shared
			//common
			//'nav' => $this->repo->nav(),
			'sec' => $this->repo->section($this->path(1)),
			'articles' => [],
			];
	} 	
	
	private function lookupData(){
		$r = [];
		foreach($this->lookups as $t=>$n){
			$r[$t] = $this->db->table($t)->orderBy($n)->pluck($n,'id');
		}
		return ['list'=>$r];
	}
	
	protected function aside($rec){
		return '';
	}
	
	function fuid($fnm){
		return str_replace('nm', 'uid', $fnm);
	}
	
	function upload($request, $rec){
		$count = 0;
		$del = [];
		foreach($this->fields as $k=>$f) if(isset($f['t']) && $f['t']=='file'){
			$file = $request->file($k);
			if($file){
				$path = $file->store($this->entity);
				if($path){
					$fuid = $this->fuid($k);
					if($rec->$fuid) $del[] = $rec->$fuid;
					$rec->$k = $file->getClientOriginalName();
					$rec->$fuid = $path;
					$count++;
				}
			}
		}
		if($count>0){
			try{
				$rec->save();
				if($del) $this->delFiles($del,1);
			}
			catch (\Illuminate\Database\QueryException $e){
				$this->flash('message-danger', 'fail-upload');
			}
			$this->flash('message-success', 'ok-upload');
		}
	}

	protected function tableFields($sub=0){
		$r = [];
		$var = $sub && $this->subTabFields ? 'subTabFields' : 'tabFields';
		foreach($this->$var as $f){
			if(isset($this->fields[$f])){
				$r[$f] = $this->fields[$f];
			}
		}
		return $r;
	}
	
	protected function getFields($create=0, $key=null){
		$r = [];
		$var = $create && $this->newRecFields ? 'newRecFields' : 'recFields';
		foreach($this->$var as $k){
			if(isset($this->fields[$k])){
				if($key===null) $r[$k] = $this->fields[$k];
				else if(isset($this->fields[$k][$key])) $r[$k] = $this->fields[$k][$key];
			}
		}
		return $r;
	}
	
	protected function validatedFields($create=0){
		return $this->getFields($create,'v');
	}
	
	protected function formFields($create=0){
		return $this->getFields($create);
	}
	
	private function preparePosted(Request $request, &$rec=null){
		$create = $request->isMethod('post');
		$s = [];
		$skip = [];
		$ff = $this->formFields($create);
		foreach($ff as $k=>$f) if(!@$f['x']){
			$val = (!isset($f['s']) || $f['s']===true)
				? $request->$k
				: (($f['s']===false)
					? $request->$k ? 1 : 0
					: $f['s']
					);
			$typ = (isset($f['t']) && $f['t']) ? $f['t'] : 'text';
			if($typ){
				if(!$val){
					if($typ=='select' && isset($f['r'])) $val = is_array($f['r']) ? '' : null;
					else if($typ=='text') $val = '';
					else if($typ=='textarea') $val = '';
					else if($typ=='checkbox') $val = 0;
					else if($typ=='number') $val = 0;
					else if($typ=='date') $val = null;
					else if($typ=='datetime-local') $val = null;
					else if($typ=='file'){
						if($create) $val = '';//insert rec: empty
						else $skip[] = $k;//update rec: skip field
					}
				}
				else{
					if($typ=='password') $val = Hash::make($val);
				}
			}
			
			if($rec===null) $s[$k] = $val;
			else $rec->$k = $val;
		}
		foreach($skip as $k){
			if($rec===null) unset($s[$k]);
			else unset($rec->$k);
		}
		return $s;
	}

	protected function path($first=0){
		$r = Route::getFacadeRoot()->current()->uri();
		if($first) $r = strtok($r,'/');
		return $r;
	}
	
}
