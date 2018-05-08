<div class="form-group row">
	<label for="{{ $name }}" class="col-md-2 col-form-label">{{ $label }}</label>
	<div class="col-md-10">
		@php ( $val = old($name, $value) )
		@php ( $val = strlen($val)>0 ? number_format(floatval($val), @$decimals ?: 0) : '' )
		<input class="form-control" {{ $order ? '' : 'autofocus' }} type="{{ $type  }}"
			@if(@$decimals)
				step="{{ pow(10, -$decimals) }}"
			@endif
			name="{{ $name }}" id="{{ $name }}" 
			value="{{ $val }}">
	</div>
</div>
