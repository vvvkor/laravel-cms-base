<div class="form-group row">
	<label for="{{ $f['n'] }}" class="col-md-2 col-form-label">{{ @$f['l'] ?: $f['n'] }}</label>
	<div class="col-md-10">
		<input class="form-control" {{ $seq ? '' : 'autofocus' }} type="{{ @$f['t'] ?: 'text'  }}"
			name="{{ $f['n'] }}" id="{{ $f['n'] }}" >
		@if(isset($rec))
			@component('cms::attach', ['table'=>$table, 'id'=>$rec->id, 'fnm'=>$rec->{$f['n']}])
			@endcomponent
			@if($rec->{$f['n']})
				<a class="text-danger" href="{{ action($controller.'@unload', ['id'=>$rec->id, 'field'=>$f['n']]) }}">Delete file</a>
			@endif
		@endif
	</div>
</div>
