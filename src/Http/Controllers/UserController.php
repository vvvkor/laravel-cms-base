<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use App\User;

class UserController extends EntityController
{
    
	protected $entity = 'users';
	
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

	protected function recordError($request, $id=0){
		//unique email
		$ref = $this->db->table('users')->where('email', $request->email)->value('id');
		if($ref && $ref!=$id){
			return ' '.__('cms::alert.unique-busy', ['field'=>__('cms::db.users-email'), 'value'=>$request->email]);
		}
		return false;
	}
}
