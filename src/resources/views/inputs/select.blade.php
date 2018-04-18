@php ( $val = old($name, $value) )
<div class="form-group row">
	<label for="{{ $name }}" class="col-md-2 col-form-label">{{ $label }}</label>
	<div class="col-md-10">
		<select class="form-control" name="{{ $name }}" id="{{ $name }}" {{ $order ? '' : 'autofocus' }}>
			@if ($empty)
				<option value="" {{ $val ? '' : 'selected' }}>-</option>
			@endif
			
			@if(isset($list))
				@if($val && !isset($list[$val]))
					<option value="{{ $val }}" selected>({{ $val }})</option>
				@endif
				@foreach($list as $k=>$v)
					<option value="{{ $k }}" {{ $val==$k ? 'selected' : '' }}>{{ $v }}</option>
				@endforeach
			@endif
		</select>
	</div>
</div>
