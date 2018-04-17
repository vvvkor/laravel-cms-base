<?php

namespace vvvkor\cms\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
	
	/*
	public function before($user, $ability)
	{
		return true;
	}
	*/
	
    public function index(User $user)
    {
        return true;
    }
	
    public function view(User $user, User $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, User $model)
    {
        return true;
    }

    public function delete(User $user, User $model)
    {
        return true;
    }
	
}
