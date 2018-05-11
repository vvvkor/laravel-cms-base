@if (@$user)
	<a class="-btn -btn-link">
	{{ __('cms::common.hello') }}, 
	<a href="{{ route('profile.edit', ['id'=>$user->id]) }}"><b>{{ $user->name }}</b></a>
	({{ __('cms::list.users-role_id-'.$user->role_id) }})
	</a>
	
	@component('cms::nav-admin')
	@endcomponent
	
	@component('cms::nav-lang', ['table'=>$table])
	@endcomponent
	
	<!--a class="float-md-right" title="Logout?" href="{{ route('logout') }}"> {{ __('cms::common.logout') }}</a-->
	<form class="float-md-right" method="post" action="{{ route('logout') }}">
		@csrf
		<button type="submit" class="btn btn-link">{{ __('cms::common.logout') }}</button>
	</form>
@else
	<a href="{{ route('login') }}">{{ __('cms::common.login') }}</a>
	@component('cms::nav-lang')
	@endcomponent
@endif