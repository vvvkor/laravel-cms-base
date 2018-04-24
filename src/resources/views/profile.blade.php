@if (@$user)
	<a class="-btn -btn-link">
	{{ __('cms::common.hello') }}, 
	<a href="{{ route('profile.edit', ['id'=>$user->id]) }}"><b>{{ $user->name }}</b></a>
	({{ __('cms::list.users-role-'.$user->role) }})
	</a>
	
	@if(cms()->isAdmin())
		{{-- admin menu --}}
		&mdash;
		@foreach (config('cms.adminEntities') as $tab)
			@if(!$loop->first)
				|
			@endif
			<a href="{{ route('admin.'.$tab.'.index') }}" class="{{ (strpos(URL::current(),route('admin.'.$tab.'.index'))===0) ? 'active font-weight-bold' : '' }}">{{ __('cms::db.'.$tab) }}</a>
		@endforeach
	@endif
	
	@if(@$table)
		{{-- languages menu (for admin sections) --}}
		&mdash;
		@foreach (config('cms.languages') as $code => $label)
			@if(!$loop->first)
				|
			@endif
			<a href="?lang={{ $code }}" class="{{ $user->lang==$code ? 'active font-weight-bold' : '' }}">{{ $label }}</a>
		@endforeach
	@endif
	
	
	<!--a class="float-md-right" title="Logout?" href="{{ route('logout') }}"> {{ __('cms::common.logout') }}</a-->
	<form class="float-md-right" method="post" action="{{ route('logout') }}">
		@csrf
		<button type="submit" class="btn btn-link">{{ __('cms::common.logout') }}</button>
	</form>
@else
	<a href="{{ route('login') }}">{{ __('cms::common.login') }}</a>
@endif