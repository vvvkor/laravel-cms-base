<?php

namespace vvvkor\cms;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use vvvkor\cms\Facades\Cms;
use vvvkor\cms\Entity;

class Section extends Entity //Model
{
    //protected $fillable = ['name','url','body','mode'];
	protected $guarded = ['id']; 

	public function scopeAllowed(Builder $query, $hidden=0)
    {
		$user = auth()->user();
		if(!Cms::isReader()){
			$query->where('e',1);
		}
		if(!Cms::isAdmin()){
			$query->where(function($q){
				$q->where('pub_dt','<',date('Y-m-d H:i:s'))
					->orWhereNull('pub_dt');
			});
			if(!$hidden) $query->where('name','<>','');
		}
		return $query;
    }
	
	public function scopeBySeq(Builder $query){
		return $query->orderBy('seq')->orderBy('id','desc');
	}
	
	public function scopeMatchLangUrl(Builder $query){
		return $query->whereRaw('length(lang)=2 and (url=lang or substr(url,1,3)=lang||\'/\' or (length(url)<>2 and substr(url,3,1)<>\'/\'))');
	}
}
