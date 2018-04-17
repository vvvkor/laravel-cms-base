<div class="form-group row">
	<label for="{{ $f['n'] }}" class="col-md-2 col-form-label">{{ @$f['l'] ?: $f['n'] }}</label>
	<div class="col-md-10">
		<select class="form-control" name="{{ $f['n'] }}" id="{{ $f['n'] }}" {{ $seq ? '' : 'autofocus' }}>
			<value="{{ old($f['n'], @$rec->{$f['n']}) }}">
			@if (@$f['u'])
				<option value="" {{ old($f['n'], @$rec->{$f['n']}) ? '' : 'selected' }}>-</option>
			@endif
			
			@if(is_array($f['r']))
				@foreach($f['r'] as $k=>$v)
					<option value="{{ $k }}" {{ old($f['n'], @$rec->{$f['n']})==$k ? 'selected' : '' }}>{{ __('cms::list.'.$v) }}</option>
				@endforeach
			@else
				@foreach($list[$f['r']] as $k=>$v)
					<option value="{{ $k }}" {{ old($f['n'], @$rec->{$f['n']})==$k ? 'selected' : '' }}>{{ $v }}</option>
				@endforeach
			@endif
		</select>
	</div>
</div>
