<?php

namespace vvvkor\cms\Models;

class EntityBasic extends Entity
{
	public $timestamps = false;
	public $incrementing = true;
	
    //protected $fillable = ['name','url','body','mode'];
	protected $guarded = ['id'];

}
