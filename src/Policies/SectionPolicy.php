<?php

namespace vvvkor\cms\Policies;

use App\User;
use vvvkor\cms\Section;
use Illuminate\Auth\Access\HandlesAuthorization;
use vvvkor\cms\Facades\Cms;

class SectionPolicy
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
	
    public function view(User $user, Section $section)
    {
		return $section->e
			? true
			: Cms::isReader();
    }

    public function create(User $user)
    {
		return Cms::isAdmin();
    }

    public function update(User $user, Section $section)
    {
		return Cms::isAdmin();
    }

    public function delete(User $user, Section $section)
    {
		return Cms::isAdmin();
    }
	
}
