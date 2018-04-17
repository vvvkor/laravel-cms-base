@if ($nav->count()>0)
<ul style="list-style:none;">
@foreach ($nav as $v)
	@if ($v->parent_id == @$root)
		@php ( $nm = $v->name==='' ? '/'.$v->url : $v->name )
		@php ( $class = ($v->e ? '' : 'text-secondary') )
		<li>
			@can('update', $v)
				<a class="{{ $class }} text-info" href="{{ action($controller.'@'.'edit', ['id'=>$v->id]) }}" title="{{ __('cms::common.edit') }}">#</a>
			@endcan
			@can('delete', $v)
				<a class="{{ $class }} text-danger" href="{{ action($controller.'@'.'show', ['id'=>$v->id]) }}" title="{{ __('cms::common.delete') }}">&times;</a>
			@endcan
			@can('view', $v)
				<a class="{{ $class }} text-secondary" href="{{ action('\vvvkor\cms\Http\Controllers\PageController@'.'view', ['url'=>$v->url]) }}" title="{{ __('cms::common.view') }}">&rarr;</a>
			@endcan
			
			{{ $nm }}
			@if (@$v->has_sub)
				@component('cms::sectree',[
					'nav' => $nav->filter(function($w) use ($v){ return ($w->parent_id==$v->id); }),
					'sec' => @$sec,
					'root' => $v->id,
					'controller' => $controller,
					])
				@endcomponent
			@endif
	@endif
@endforeach
</ul>
@endif