@if (@$user)
	<a class="-btn -btn-link">
	{{ __('cms::common.hello') }}, 
	<a href="{{ route('profile.edit', ['id'=>$user->id]) }}"><b>{{ $user->name }}</b></a>
	({{ __('cms::list.users-role-'.$user->role) }})
	</a>
	
	@if(cms()->isAdmin())
		&mdash;
		<a href="{{ route('admin.sections.index') }}">{{ __('cms::db.sections') }}</a>
		|
		<a href="{{ route('admin.users.index') }}">{{ __('cms::db.users') }}</a>
	@endif
	
	
	<!--a class="float-md-right" title="Logout?" href="{{ route('logout') }}"> {{ __('cms::common.logout') }}</a-->
	<form class="float-md-right" method="post" action="{{ route('logout') }}">
		@csrf
		<button type="submit" class="btn btn-link">{{ __('cms::common.logout') }}</button>
	</form>
@else
	<a href="{{ route('login') }}">{{ __('cms::common.login') }}</a>
@endif