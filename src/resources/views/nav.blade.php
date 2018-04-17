@if ($nav->count()>0)
<nav class="navbar navbar-dark bg-primary navbar-expand-md">
	<b><a class="navbar-brand" href="{{ route('front','') }}">{{ config('app.name') }}</a></b>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
		<span class="navbar-toggler-icon"></span>
	</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav">
@foreach ($nav as $v)
	@if ($v->parent_id == $root)
		@php ( $nm = $v->name==='' ? '/'.$v->url : $v->name )
		@php ( $active = (
				($sec && 
					(
					$v->id == $sec->id || 
					($v->id == $sec->parent_id && $sec->mode != '')
					)
				) ||
				(!$sec && url($v->url) == URL::current())
			) ? 'active' : ''
		)
		@php ( $class = ($v->e || $active ? '' : 'text-warning ') )
		<li class="nav-item {{ @$v->has_sub ? 'dropdown' : ''}} {{ $active }}">
			@if (@$v->has_sub)
				<a href="#" class="nav-link dropdown-toggle {{ $class }}" data-toggle="dropdown">{{ $nm }}</a>
				@component('cms::subnav',[
					'nav' => $nav, // ->filter(function($w) use ($v){ return ($w->parent_id==$v->id); }),
					'sec' => $sec,
					'root' => $v->id
					])
				@endcomponent
			@else
				<a class="nav-link {{ $class }}" href="{{ route('front', $v->url) }}">{{ $nm }}</a>
			@endif
	@endif
@endforeach
</ul>
</div>
</nav>
@endif