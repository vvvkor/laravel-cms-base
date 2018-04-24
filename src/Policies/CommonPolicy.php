<?php

namespace vvvkor\cms\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;
use vvvkor\cms\Facades\Cms;

abstract class CommonPolicy
{
    use HandlesAuthorization;
	
	/*
	public function before($user, $ability)
	{
		return Cms::isAdmin();
	}
	*/
	
    public function index(User $user)
    {
		return Cms::isAdmin();
    }
	
    public function view(User $user, Model $model)
    {
		return Cms::isAdmin();
    }

    public function create(User $user)
    {
		return Cms::isAdmin();
    }

    public function update(User $user, Model $model)
    {
		return Cms::isAdmin();
    }

    public function delete(User $user, Model $model)
    {
		return Cms::isAdmin();
    }
	
}
