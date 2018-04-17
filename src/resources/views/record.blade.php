<h2 class="my-3">
<a href="{{ action($controller.'@index') }}">{{ __('cms::db.'.$table.'1') }}</a>
@if(isset($rec))
	<span class="text-secondary">#{{ $rec->id }}</span>
	<a href="{{ action($controller.'@edit',$rec->id) }}">{{ $rec->name }}</a>
@else
	<a class="text-secondary" href="{{ action($controller.'@create') }}">{{ __('cms::common.add') }}</a>
@endif
</h2>

@foreach ($errors->all() as $err)
<div class="alert alert-warning">
	{{ $err }}
</div>
@endforeach

<form method="POST" action="{{ @$rec ? action($controller.'@update',$rec->id) : action($controller.'@store') }}"
enctype="multipart/form-data">
	@csrf
	@if(@$rec)
		@method('PUT')
	@endif
	
	
	@foreach ($fields as $seq=>$f)
		@include(@$f['t'] ? 'cms::inputs.'.$f['t'] : 'cms::inputs.text')
	@endforeach
	
    <div>
		<span class="label"></span>
        <label>
			@if(@$rec)
				<input type="submit" value="{{ __('cms::common.save') }}" class="btn btn-primary">
			@else
				<input type="submit" value="{{ __('cms::common.add') }}" class="btn btn-success">
			@endif
			<a href="{{ action($controller.'@index') }}" class="btn btn-link text-secondary">{{ __('cms::common.cancel') }}</a>
		</label>
    </div>

</form>
