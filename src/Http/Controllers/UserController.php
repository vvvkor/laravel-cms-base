<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use App\User;

class UserController extends CommonController
{
    
	protected $entity = 'users';
	protected $policy = true;
	protected $uniques = ['email'];
	
	protected $tabFields  = ['id','name','email','lang','enabled','role_id'];
	protected $subTabFields  = ['id','name','email','enabled'];
	protected $recFields    = ['name','email','lang','enabled','role_id'];
	protected $newRecFields = ['name','email','lang','enabled','role_id','password','password_confirmation'];
	
	protected $fields = [
		//v:validate='', t:type=text, r:relation|[], n:nullable,
		//x:skip_in_query, d:number_decimals, a:auto_value_if_absent_in_request
		'id' => [
			],
		'name' => [
			'v' => 'required',
			],
		'email' => [
			'v' => 'required',
			't' => 'email',
			],
		'password' => [
			'v' => 'required|min:6|confirmed',
			't' => 'password',
			],
		'password_confirmation' => [
			'v' => 'required|min:6',
			't' => 'password',
			'x' => 1,
			],
		'lang' => [
			'v' => 'max:2',
			],
		'enabled' => [
			't' => 'checkbox',
			],
		'role_id' => [
			't' => 'select',
			'r' => array('','free','admin'),
			],
		];
	
	public function __construct(Repo $repo, User $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
   	}
}
