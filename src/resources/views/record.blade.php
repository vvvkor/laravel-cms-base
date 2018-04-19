<h2 class="my-3">
<a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table.'1') }}</a>
@if(isset($rec))
	<span class="text-secondary">#{{ $rec->id }}</span>
	<a href="{{ route('admin.'.$table.'.edit',$rec->id) }}" class="{{ $rec->e ? '' : 'bg-warning' }}">{{ $rec->name }}</a>
@else
	<a class="text-secondary" href="{{ route('admin.'.$table.'.create') }}">{{ __('cms::common.add') }}</a>
@endif
</h2>

@foreach ($errors->all() as $err)
<div class="alert alert-warning">
	{{ $err }}
</div>
@endforeach

<form method="POST" action="{{ @$rec ? route('admin.'.$table.'.update',$rec->id) : route('admin.'.$table.'.store') }}"
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
			<a href="{{ route('admin.'.$table.'.index') }}" class="btn btn-link text-secondary">{{ __('cms::common.cancel') }}</a>
			@if(@$rec)
				@can('delete', $rec)
					<a href="{{ route('admin.'.$table.'.show', ['id'=>$rec->id]) }}" class="btn btn-link text-danger">{{ __('cms::common.delete') }}</a>
				@endcan
			@endif
		</label>
    </div>

</form>
