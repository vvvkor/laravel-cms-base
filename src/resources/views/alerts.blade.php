@php ( $mtypes = ['danger','success','warning','primary','secondary'] )
@foreach ($mtypes as $mtype)
	@if (Session::has('message-'.$mtype))
		@php ( $msg = Session::get('message-'.$mtype) )
		@php ( $msg = is_array($msg) ? $msg : [$msg] )
		@foreach($msg as $m)
			<div class="alert alert-{{ $mtype }}">{{ substr($m,0,1)==' ' ? trim($m) : __('cms::alert.'.$m) }}</div>
		@endforeach
	@endif
@endforeach
