@if(isset($heading))
	@if(strlen($heading)>0)
		<h2 class="my-3">{{ $heading }}</h3>
	@endif
@else
	<h2 class="my-3">
	<a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table.'1') }}</a>
	@if(isset($rec))
		<span class="text-secondary">#{{ $rec->id }}</span>
		<a href="{{ route('admin.'.$table.'.edit',$rec->id) }}" class="{{ (isset($rec->e) && !$rec->e) ? 'bg-warning' : '' }}">{{ $rec->name }}</a>
		@if($table=='sections')
			<a href="{{ route('page', ['url'=>$rec->url]) }}" class="text-secondary" title="{{ __('cms::common.view') }}">&rarr;</a>
		@endif
	@else
		<a class="text-secondary" href="{{ route('admin.'.$table.'.create') }}">{{ __('cms::common.add') }}</a>
	@endif
	</h2>
@endif

@foreach ($errors->all() as $err)
<div class="alert alert-warning">
	{{ $err }}
</div>
@endforeach

<form method="POST" action="{{ isset($route) ? $route : (@$rec ? route('admin.'.$table.'.update',$rec->id) : route('admin.'.$table.'.store')) }}"
enctype="multipart/form-data">
	@csrf
	@if(@$rec)
		@method('PUT')
	@endif
	
	
	@php( $order = 0 )
	@foreach ($fields as $k=>$f)
		@php ($type = @$f['t'] ? $f['t'] : 'text' )
		@component('cms::inputs.'.$type, [
			'table' => $table,
			'rec' => isset($rec) ? $rec : [],
			'order' => $order++,
			'name' => $k,
			'label' => isset($f['l']) ? $f['l'] : $k,
			'type' => $type,
			'decimals' => isset($f['d']) ? $f['d'] : null,
			'value' => isset($rec->$k) ? $rec->$k : '',
			'empty' => isset($f['u']) ? $f['u'] : false,
			'list' => isset($f['r'])
				? (is_array($f['r']) ? $f['r'] : $list[$f['r']])
				: [],
			])
		@endcomponent
	@endforeach
	
    <div>
		<span class="label"></span>
        <label>
			@if(@$rec)
				<input type="submit" value="{{ __('cms::common.save') }}" class="btn btn-primary">
			@else
				<input type="submit" value="{{ __('cms::common.add') }}" class="btn btn-success">
			@endif
			
			@if(!isset($links) || $links!==false)
				<a href="{{ route('admin.'.$table.'.index') }}" class="btn btn-link text-secondary">{{ __('cms::common.cancel') }}</a>
				@if(@$rec)
					@php ( $canDelete = @$policy ? 0 : 1 )
					@if(@$policy)
						@can('delete', $rec)
							@php ( $canDelete = 1 )
						@endcan
					@endif
					@if($canDelete)
						<a href="{{ route('admin.'.$table.'.show', ['id'=>$rec->id]) }}" class="btn btn-link text-danger">{{ __('cms::common.delete') }}</a>
					@endif
				@endif
			@endif
		</label>
    </div>

</form>
