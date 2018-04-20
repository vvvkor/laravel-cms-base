@if($nav)
	@foreach($nav as $route => $label)
		<a href="{{ route($route) }}">{{ $label }}</a>
	@endforeach
@endif