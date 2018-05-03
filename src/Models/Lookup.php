<?php

namespace vvvkor\cms\Models;

class Lookup extends Entity
{
	public $timestamps = false;
	public $incrementing = false;
	
    //protected $fillable = ['name','url','body','mode'];
	protected $guarded = [/*'id'*/];

}
