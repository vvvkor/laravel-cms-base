<?php

namespace vvvkor\cms\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Database\DatabaseManager;
use vvvkor\cms\Repositories\SectionRepository as Repo;
use App\User;

class ProfileController extends UserController
{
    
	protected $entity = 'users';
	
	protected $tabFields  = ['id','name','email','lang','e','role'];
	protected $subTabFields  = ['id','name','email','e'];
	protected $recFields    = ['name','lang'];

	public function index(Request $request){
		return $this->form();
	}
	
	public function edit($id, $add=null){
		return $this->form();
	}
	
	public function show($id=''){
		return $this->form();
	}
	
	public function confirmDelete($id){
		return $this->form();
	}
	
	public function store(Request $request){
		return redirect(route('profile.index'));
	}
	
	public function destroy($id){
		return redirect(route('profile.index'));
	}
	
    public function update(Request $request, $id, $route=null){
		return parent::update($request, auth()->user()->id, route('profile.index'));
	}
	
	function form(){
		$uid = auth()->user()->id;
		return parent::edit($uid, [
			'route' => route('profile.update', ['id'=>$uid]),
			'title' => __('cms::common.profile').': '.auth()->user()->email,
			'heading' => __('cms::common.profile').': '.auth()->user()->email,
			'links' => false,
			]);
	}
	
	//dont check policy
	//any authorized user has access to his profile
	function authorize($ability, $arguments = []){
		return true;
	}
	
}
