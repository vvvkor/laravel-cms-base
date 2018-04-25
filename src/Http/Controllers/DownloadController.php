<?php

namespace vvvkor\cms\Http\Controllers;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use vvvkor\cms\Section;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Response;
//use Illuminate\Support\Facades\File;
//use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class DownloadController extends Controller
{
	
	private $dirThumbs = 'thumbs';
	
	public function __construct(Repo $repo, Section $model, DatabaseManager $db){
		$this->db = $db;
		$this->repo = $repo;
	}
	
	private function find($entity, $id){
		if($entity=='sections'){
			$r = $this->repo->section($id,null,'id');//checks access!
		}
		else{
			$r = $this->db->table($entity)->find($id);
		}
		return $r;
	}
	
    public function download($entity, $id, $file=null){
		//app('debugbar')->disable();
		$f = $this->find($entity, $id);
		if(!$f) abort(404);
		return Storage::download($f->fuid);
	}

	public function getfile($entity, $id, $width=null, $height=null, $filename=null){
		//app('debugbar')->disable();
		
		//get from db
		$f = $this->find($entity, $id);
		if(!$f) abort(404,$id);
		$path = $f->fuid;
		if(!Storage::exists($path)) abort(404,$path);
		
		//size and filename
		if($filename===null){
			if($width!==null && !preg_match('/^\d+$/',$width)){
				$filename = $width;
				$width = $height = null;
			}
			else if($height!==null && !preg_match('/^\d+$/',$height)){
				$filename = $height;
				$height = 0;
			}
		}
		//echo $filename;exit;

		if($width){
			//output thumb
			//$manager = new ImageManager(/*array('driver' => 'imagick')*/);
			return Image::cache(function($im) use ($path, $width, $height){
					// \Log::info('generate thumb to cache');
					$im->make(Storage::get($path))->fit($width, $height ?: null);
				},
				config('cms.cacheThumbsTimeout',60),
				true
				)->response();
		}
		else{
			//output entire file
			//1. simplest: no headers
			//return new Response(Storage::get($path), 200);
			$spath = $this->spath($path);
			//2. with filename in headers
			return response()->download(
					$spath,
					$filename===null ? $f->fnm : $filename,
					[],
					'inline'
				);
			//3. simple, without filename in headers
			//return response()->file($spath,[]);
			
			//This will return the full path to the requested file,
			//Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($file)
		}
	}
	
	protected function spath($path){
		return storage_path('app/'.$path);
	}
}
