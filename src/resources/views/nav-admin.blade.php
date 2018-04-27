@if(cms()->isAdmin())
	&mdash;
	@foreach (config('cms.adminEntities') as $tab)
		@if(!$loop->first)
			|
		@endif
		<a href="{{ route('admin.'.$tab.'.index') }}" class="{{ (strpos(URL::current(),route('admin.'.$tab.'.index'))===0) ? 'active font-weight-bold' : '' }}">{{ __('cms::db.'.$tab) }}</a>
	@endforeach
@endif
