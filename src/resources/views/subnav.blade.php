@if ($nav->count()>0)
<div class="dropdown-menu">
@foreach ($nav as $v)
	@if ($v->parent_id == $root)
		@php ( $nm = $v->name==='' ? '/'.$v->url : $v->name )
		@php ( $active = (
				($sec && 
					(
					$v->id == $sec->id || 
					($v->id == $sec->parent_id && $sec->mode != '')
					)
				)
				/* || (!$sec && url($v->url) == URL::current()) */
				/* || (!$sec && ($v->url) == request()->path()) */
				|| (!$sec && $v->url && strpos(request()->path(), $v->url)===0)
			) ? 'active' : ''
		)
		@php ( $class = ($v->enabled || $active ? '' : 'text-warning ') )

			@if (@$v->has_sub)
				<a href="#" class="nav-link dropdown-toggle {{ $class }} {{ $active }}" data-toggle="dropdown">{{ $nm }}</a>
				@component('cms::subnav',[
					'nav' => $nav, // ->filter(function($w) use ($v){ return ($w->parent_id==$v->id); }),
					'sec' => $sec,
					'root' => $v->id
					])
				@endcomponent
			@else
				<a class="dropdown-item {{ $class }} {{ $active }}" href="{{ route('page', ['url'=>$v->url]) }}">{{ $nm }}</a>
			@endif
	@endif
@endforeach
</div>
@endif