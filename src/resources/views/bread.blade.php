@php ($cur = $sec)
@php ($bread = [])

@while($cur)
	@php ( array_unshift($bread,$cur) )
	@php ($cur = $cur->parent_id ? (@$nav[$cur->parent_id] ?: cms()->section($cur->parent_id,null,'id')) : null)
@endwhile

@if ($bread && (!@$table || ($table=='sections' /*&& $sec->parent_id*/)))
	<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
	@if(@$table)
		<li class="breadcrumb-item"><a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table) }}</a>
	@endif

	@foreach($bread as $v)
		<li class="breadcrumb-item {{ $loop->last ? '' : 'active' }}">
		@if ($loop->last)
			{{ $v->name }}
		@else
			@if(@$table)
				<a href="{{ route('admin.'.$table.'.edit', @$v->id) }}">{{ $v->name }}</a>
			@else
				<a href="{{ route('page', ['url'=>@$v->url]) }}">{{ $v->name }}</a>
			@endif
		@endif
	@endforeach
	</ol>
	</nav>
@endif