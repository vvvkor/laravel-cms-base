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
	
	protected $tabFields  = ['id','name','email','lang','e','role'];
	protected $subTabFields  = ['id','name','email','e'];
	protected $recFields    = ['name','email','lang','e','role'];
	protected $newRecFields = ['name','email','lang','e','role','password','password_confirmation'];
	
	protected $fields = [
		//v:validate='', :save=true, t:type=text, r:relation|[], u:nullable,
		//x:skip_in_query
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
		'e' => [
			't' => 'checkbox',
			],
		'role' => [
			't' => 'select',
			'r' => array('','r','a'),
			],
		];
	
	public function __construct(Repo $repo, User $model, DatabaseManager $db){
		parent::__construct($repo, $model, $db);
   	}
}
