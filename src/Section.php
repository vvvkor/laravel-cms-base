<?php

namespace vvvkor\cms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Section extends Model
{
    //protected $fillable = ['name','url','body','mode'];
	protected $guarded = ['id']; 

	public function scopeAllowed(Builder $query, $hidden=0)
    {
		if(!auth()->user()){
			$query->where('e',1);
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
}
