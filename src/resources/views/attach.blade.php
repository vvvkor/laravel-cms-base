@if(isset($fnm) && $fnm)
	@if(preg_match('/\.(png|jpe?g|gif|bmp|svg)$/i',$fnm))
		{{--
		@php ( $furl = asset('storage/'.@$fuid) )
		@php ( $furl = route('getfile',['entity'=>$table, 'id'=>$id, 'width'=>$fnm]) )
		@php ( $furl_thumb = route('getfile',['entity'=>$table, 'id'=>$id, 'width'=>150, 'height'=>150, 'filename'=>$fnm]) )
		--}}
		@php ( $furl = route('getfile',[$table,$id,$fnm]) )
		@php ( $furl_thumb = route('getfile',[$table,$id,150,$fnm]) )
		<a href="{{ $furl }}"><img
			class="my-3 img-thumbnail"
			alt="{{ $fnm }}"
			title="{{ $fnm }}"
			src="{{ $furl_thumb }}"
			></a>
	@elseif (preg_match('/\.(txt|log)$/i',$fnm))
		<a href="{{ route('getfile',['entity'=>$table, 'id'=>$id, 'file'=>$fnm]) }}">View {{ $fnm }}</a>
	@else
		<a href="{{ route('download',['entity'=>$table, 'id'=>$id, 'file'=>$fnm]) }}">Download {{ $fnm }}</a>
	@endif
@endif
