<div class="form-group row">
	<label for="{{ $f['n'] }}" class="col-md-2 col-form-label">{{ @$f['l'] ?: $f['n'] }}</label>
	<div class="col-md-10">
		<input class="form-control" {{ $seq ? '' : 'autofocus' }} type="{{ @$f['t'] ?: 'text'  }}"
			name="{{ $f['n'] }}" id="{{ $f['n'] }}" 
			value="{{ old($f['n'], @$rec->{$f['n']}) }}">
	</div>
</div>
