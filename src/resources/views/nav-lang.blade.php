@php ( $langs = config('cms.languages') )
@if(sizeof($langs)>1)
	@if(@$table)
		{{-- for admin sections --}}
		&mdash;
		@foreach ($langs as $code => $label)
			@if(!$loop->first)
				|
			@endif
			<a href="?lang={{ $code }}" class="{{ $user->lang==$code ? 'active font-weight-bold' : '' }}">{{ $label }}</a>
		@endforeach
	@else
		{{-- for pages --}}
		&mdash;
		@php ( $trans = cms()->translations() )
		@foreach ($langs as $code => $label)
			@if(!$loop->first)
				|
			@endif
			@if(@$lang==$code)
				<span class="active font-weight-bold">{{ $label }}</span>
			@elseif(isset($trans[$code]))
				<a href="{{ route('page', ['url'=>$trans[$code]['url']]) }}">{{ $label }}{{-- ':'.$trans[$code]['name'] --}}</a>
			@else
				<span class="text-secondary">{{ $label }}</span>
			@endif
		@endforeach
	@endif
@endif
