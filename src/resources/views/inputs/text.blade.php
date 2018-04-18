<div class="form-group row">
	<label for="{{ $name }}" class="col-md-2 col-form-label">{{ $label }}</label>
	<div class="col-md-10">
		<input class="form-control" {{ $order ? '' : 'autofocus' }} type="{{ $type  }}"
			name="{{ $name }}" id="{{ $name }}" 
			value="{{ old($name, $value) }}">
	</div>
</div>
