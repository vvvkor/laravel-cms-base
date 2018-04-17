<div class="row">
	<div class="offset-md-2 col-md-10">
		<div class="form-check">
			<input class="form-check-input" {{ $seq ? '' : 'autofocus' }} type="checkbox" 
				name="{{ $f['n'] }}" id="{{ $f['n'] }}"
				value="1" {{ old($f['n'], @$rec->{$f['n']}) ? 'checked' : '' }}>
			<label for="{{ $f['n'] }}">{{ @$f['l'] ?: $f['n'] }}</label>
		</div>
	</div>
</div>
