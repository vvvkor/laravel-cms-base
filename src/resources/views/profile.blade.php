@if (@$user)
	<a class="btn btn-link">
	{{ __('cms::common.hello') }}, <b>{{ $user->name }}</b>
	</a>
	<!--a class="float-md-right" title="Logout?" href="{{ route('logout') }}"> {{ __('cms::common.logout') }}</a-->
	<form class="float-md-right" method="post" action="{{ route('logout') }}">
		@csrf
		<button type="submit" class="btn btn-link">{{ __('cms::common.logout') }}</button>
	</form>
@else
	<a href="{{ route('login') }}">{{ __('cms::common.login') }}</a>
@endif