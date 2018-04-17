@foreach ($articles as $v)
	@component('cms::section',['sec'=>$v,'current'=>0])
	@endcomponent
@endforeach
