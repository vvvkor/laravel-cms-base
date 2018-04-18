<div class="row">
	<div class="offset-md-2 col-md-10">
		<div class="form-check">
			<input class="form-check-input" {{ $order ? '' : 'autofocus' }} type="checkbox" 
				name="{{ $name }}" id="{{ $name }}"
				value="1" {{ old($name, $value) ? 'checked' : '' }}>
			<label for="{{ $name }}">{{ $label }}</label>
		</div>
	</div>
</div>
