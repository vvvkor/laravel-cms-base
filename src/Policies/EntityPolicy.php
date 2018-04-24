<?php

namespace vvvkor\cms\Policies;

//use App\User;
//use vvvkor\cms\Entity;
use Illuminate\Auth\Access\HandlesAuthorization;
use vvvkor\cms\Facades\Cms;

abstract class EntityPolicy extends CommonPolicy
{
    use HandlesAuthorization;
	
/*
    public function view(User $user, Entity $model)
    {
		return Cms::isAdmin();
    }
*/
}
