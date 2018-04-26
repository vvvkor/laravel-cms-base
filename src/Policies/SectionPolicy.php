<?php

namespace vvvkor\cms\Policies;

use App\User;
use Illuminate\Database\Eloquent\Model;
//use vvvkor\cms\Entity;
//use vvvkor\cms\Section;
use vvvkor\cms\Facades\Cms;

class SectionPolicy extends CommonPolicy
{
	
    public function view(User $user, Model $model) //Section $model
    {
		return $model->e
			? true
			: Cms::isReader();
    }

	
}
