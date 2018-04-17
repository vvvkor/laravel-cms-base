<?php

namespace vvvkor\cms\Policies;

use App\User;
use vvvkor\cms\Section;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
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
	
    public function view(User $user, Section $section)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Section $section)
    {
        return true;
    }

    public function delete(User $user, Section $section)
    {
        return true;
    }
}
