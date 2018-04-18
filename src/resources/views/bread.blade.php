@php ($cur = $sec)
@php ($bread = [])

@while($cur)
	@php ( array_unshift($bread,$cur) )
	@php ($cur = $cur->parent_id ? $nav[$cur->parent_id] : null)
@endwhile

@if ($bread)
	<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
	@foreach($bread as $v)
		<li class="breadcrumb-item {{ $loop->last ? '' : 'active' }}">
		@if ($loop->last)
			{{ $v->name }}
		@else
			<a href="{{ route('page', $v->url) }}">{{ $v->name }}</a>
		@endif
	@endforeach
	</ol>
	</nav>
@endif