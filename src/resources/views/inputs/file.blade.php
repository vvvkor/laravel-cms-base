<div class="form-group row">
	<label for="{{ $name }}" class="col-md-2 col-form-label">{{ $label }}</label>
	<div class="col-md-10">
		<input class="form-control" {{ $order ? '' : 'autofocus' }} type="{{ $type }}"
			name="{{ $name }}" id="{{ $name }}" >
		@if(isset($rec) && $rec)
			@component('cms::attach', ['table'=>$table, 'id'=>$rec->id, 'fnm'=>$rec->$name])
			@endcomponent
			@if($rec->$name)
				<a class="text-danger" href="{{ action($controller.'@'.'unload', ['id'=>$rec->id, 'field'=>$name]) }}">Delete file</a>
			@endif
		@endif
	</div>
</div>
