<?php

namespace vvvkor\cms;

class EntityBasic extends Entity
{
	public $timestamps = false;
	public $incrementing = true;
	
    //protected $fillable = ['name','url','body','mode'];
	protected $guarded = ['id'];

}
