@if ($nav->count()>0)
<ul style="list-style:none;">
@foreach ($nav as $v)
	@if ($v->parent_id == @$root)
		@php ( $nm = $v->name==='' ? '/'.$v->url : $v->name )
		<li>
			@can('update', $v)
				<a class="text-info" href="{{ route('admin.sections.edit', ['id'=>$v->id]) }}" title="{{ __('cms::common.edit') }}">#</a>
			@endcan
			@can('delete', $v)
				<a class="text-danger" href="{{ route('admin.sections.show', ['id'=>$v->id]) }}" title="{{ __('cms::common.delete') }}">&times;</a>
			@endcan
			@can('view', $v)
				<a class="text-secondary" href="{{ route('page', ['url'=>$v->url]) }}" title="{{ __('cms::common.view') }}">&rarr;</a>
			@endcan
			
			{{ $nm }}
			@if (@$v->has_sub)
				@component('cms::sectree',[
					'nav' => $nav->filter(function($w) use ($v){ return ($w->parent_id==$v->id); }),
					'root' => $v->id,
					])
				@endcomponent
			@endif
	@endif
@endforeach
</ul>
@endif