@foreach ($articles as $v)
	@component('cms::article',['sec'=>$v])
	@endcomponent
@endforeach

{{ $articles->links() }}