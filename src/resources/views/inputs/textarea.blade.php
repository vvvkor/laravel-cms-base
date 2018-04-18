@push('scripts')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
	<script>CKEDITOR.replaceAll('ckeditor');</script>
@endpush

<div class="form-group -row">
	<label for="{{ $name }}" class="-col-md-2 col-form-label">{{ $label }}</label>
	<div class="-col-md-10">
		<textarea class="form-control ckeditor" {{ $order ? '' : 'autofocus' }}
			name="{{ $name }}" id="{{ $name }}" 
			cols="80" rows="10">{{ old($name, $value) }}</textarea>
	</div>
</div>
