@extends('cms::page')

@section('bread','')


@section('main')
<div class="row">
	<div class="col-md-9">
		@include('cms::record')
	</div>

	@if(strlen(@$aside)>0)
		<aside class="col-md-3">
			{!! $aside !!}
		</aside>
	@endif

</div>
@endsection
