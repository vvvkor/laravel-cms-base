<?php

namespace vvvkor\cms\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use vvvkor\cms\Facades\Cms;

class UserPolicy
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
	
    public function view(User $user, User $model)
    {
		return Cms::isAdmin();
    }

    public function create(User $user)
    {
		return Cms::isAdmin();
    }

    public function update(User $user, User $model)
    {
		return Cms::isAdmin();
    }

    public function delete(User $user, User $model)
    {
		return Cms::isAdmin();
    }
	
}
