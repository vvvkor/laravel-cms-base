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
	
	protected $repo;
	protected $model;
	protected $db;

	protected $modelClass;
	protected $controllerClass;
	protected $validatorCreate;
	protected $validatorUpdate;
	
	public function __construct(Repo $repo, Model $model, DatabaseManager $db){
		$this->repo = $repo;
		$this->model = $model;
		$this->db = $db;
		$this->modelClass = get_class($model);//for controllers
		//$c = explode('\\', get_class($this));
		//$this->controllerClass = array_pop($c);
		$this->controllerClass = '\\' . get_class($this);//@@ for views
        //$this->authorizeResource($this->model);
		
		//$this->share();
		$this->middleware(function ($request, $next) {
			$ff = $this->formFields(1);
			$this->validatorCreate = $this->keyed($ff,'v','n');
			$ff = $this->formFields(0);
			$this->validatorUpdate = $this->keyed($ff,'v','n');
            $this->prepare();
            return $next($request);
        });

	}
	
	//set lang
	private function prepare(){
		//user
		$user = auth()->user();
		if($user && $user->lang){
			app()->setLocale($user->lang);
		}
		$this->share();
	}
	
	//actions
	
    public function index()
    {
		//$this->authorize('index', $this->modelClass);
		$cols = $this->db->getSchemaBuilder()->getColumnListing($this->entity);
		$d = $this->model->paginate(5);
		return view('cms::page-table', [
			'title'=>__('cms::db.'.$this->entity),
			'columns'=>$cols,
			'records'=>$d,
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
        $request->validate($this->validatorCreate);
        
		try{
			$d = $this->preparePosted($request);
			$rec = $this->model->create($d);
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-create', $e);
			return redirect(action($this->controllerClass.'@create'));
		}
		$this->flash('message-success', 'ok-create');
		$this->upload($request, $rec);
        return redirect(action($this->controllerClass.'@edit',['id'=>$rec->id]));
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
			] 
			+ $this->data() 
			+ $this->lookupData()
			);
	}
	
    public function update(Request $request, $id)
    {
        $request->validate($this->validatorUpdate);
        $rec = $this->model->findOrFail($id);
		$this->authorize('update', $rec);
        $s = $this->preparePosted($request, $rec);
		try{
			$rec->save();
		}
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-save', $e);
			return redirect(action($this->controllerClass.'@edit',$id));
		}
		//$request->session()->flash('message-success', 'Saved');
		$this->flash('message-success', 'ok-save');
		$this->upload($request, $rec);
        return redirect(action($this->controllerClass.'@edit',['id'=>$rec->id]));
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
			return redirect(action($this->controllerClass.'@index'));
		}
 		$this->flash('message-success','ok-delete');
        return redirect(action($this->controllerClass.'@index'));
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

	/*
    public function doDelete($id)
    {
		$rec = $this->model->findOrFail($id);
		$this->authorize('delete', $rec);
		try{
			$this->model->destroy($id);
		}
		//catch (\Exception $e){
		catch (\Illuminate\Database\QueryException $e){
			$this->flash('message-danger', 'fail-delete', $e);
			return redirect(action($this->controllerClass.'@index'));
		}
 		$this->flash('message-success','ok-delete');
        return redirect(action($this->controllerClass.'@index'));
   }
   */
   
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
        return redirect(action($this->controllerClass.'@edit',['id'=>$rec->id]));
	   
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
			'controller' => $this->controllerClass, // for action links
			'model' => $this->modelClass, // for can(create)
			'table' => $this->entity, // subs, attach ...
			'nmf' => $this->nmf, // hints
			//common
			'nav' => $this->repo->nav(),
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
	
	private function keyed(&$a,$val_key,$key='n',$def=null){
		return array_reduce($a,function($r,$v) use($key, $val_key, $def){
				if(isset($v[$val_key])) $r[$v[$key]] = $v[$val_key];
				else if($def!==null) $r[$v[$key]] = $def;
				return $r;
			},
			[]);
		
	}
	
	function fuid($fnm){
		return str_replace('nm', 'uid', $fnm);
	}
	
	function upload($request, $rec){
		$count = 0;
		$del = [];
		foreach($this->fields as $f) if(isset($f['t']) && $f['t']=='file'){
			$file = $request->file($f['n']);
			if($file){
				$path = $file->store($this->entity);
				if($path){
					$fuid = $this->fuid($f['n']);
					if($rec->$fuid) $del[] = $rec->$fuid;
					$rec->{$f['n']} = $file->getClientOriginalName();
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

	private function formFields($create=0){
		$ff = $this->fields;
		foreach($ff as $k=>$v){
			$ff[$k]['l'] = __('cms::db.'.$this->entity.'-'.$v['n']);
			if(isset($ff[$k]['w']) && ($ff[$k]['w'] xor !$create)){
				/*if(@$v['t']=='password')*/ unset($ff[$k]);
			}
		}
		return $ff;
	}

	private function preparePosted(Request $request, &$rec=null){
		$create = $request->isMethod('post');
		$s = [];
		$skip = [];
		$ff = $this->formFields($create);
		foreach($ff as $f) if(isset($f['n']) && !@$f['x']){
			$k = $f['n'];
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
