@php( $links = $images = [] )

@foreach ($files as $v)
	@if(preg_match('/\.(png|jpe?g|gif|bmp|svg)$/i',$v->fnm))
		@php( $images[] = $v )
	@else
		@php( $links[] = $v )
	@endif
@endforeach

@if($links)
	<h3>{{ __('cms::common.downloads') }}</h3>
	<ul>
	@foreach ($links as $v)
		<li>
		@component('cms::attach', ['table'=>'sections', 'id'=>$v->id, 'fnm'=>$v->fnm])
		@endcomponent
	@endforeach
	</ul>
@endif

@if($images)
	<h3>{{ __('cms::common.gallery') }}</h3>
	<div>
	@foreach ($images as $v)
		@component('cms::attach', ['table'=>'sections', 'id'=>$v->id, 'fnm'=>$v->fnm])
		@endcomponent
	@endforeach
	</div>
@endif
