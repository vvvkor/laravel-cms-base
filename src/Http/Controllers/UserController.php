<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use App\User;

class UserController extends EntityController
{
    
	protected $entity = 'users';
	
	protected $fields = [
		//v:validate='', :save=true, t:type=text, r:relation|[], 
		//x:skip_in_query, w=when_to_show (0=create, 1=edit)
		[
		'n' => 'name',
		'v' => 'required',
		],
		[
		'n' => 'email',
		'v' => 'required',
		't' => 'email',
		],
		[
		'n' => 'password',
		'v' => 'required|min:6|confirmed',
		't' => 'password',
		'w' => 0,
		],
		[
		'n' => 'password_confirmation',
		'v' => 'required|min:6',
		't' => 'password',
		'w' => 0,
		'x' => 1,
		],
		[
		'n' => 'lang',
		'v' => 'max:2',
		],
		[
		'n' => 'e',
		't' => 'checkbox',
		],
		];
	
	public function __construct(Repo $repo, User $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
   	}
}
