@push('scripts')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
	<script>CKEDITOR.replaceAll('ckeditor');</script>
@endpush

<div class="form-group -row">
	<label for="{{ $f['n'] }}" class="-col-md-2 col-form-label">{{ @$f['l'] ?: $f['n'] }}</label>
	<div class="-col-md-10">
		<textarea class="form-control ckeditor" {{ $seq ? '' : 'autofocus' }}
			name="{{ $f['n'] }}" id="{{ $f['n'] }}" 
			cols="80" rows="10">{{ old($f['n'], @$rec->{$f['n']}) }}</textarea>
	</div>
</div>
