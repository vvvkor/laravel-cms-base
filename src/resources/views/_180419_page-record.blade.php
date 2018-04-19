@extends('cms::page')

@section('bread','')


@section('main')
<div class="row">
	<div class="col-md-9">
		@include('cms::record')
	</div>

	<aside class="col-md-3">
		{!! $aside !!}
		@if (@$rec)
			@if(1)
				@inject('record', '\vvvkor\cms\Services\RecordService')
				{!! $record->subSections($table, $rec->id, 'cms::table') !!}
			{{--
			@else
				<h3>inject</h3>
				@inject('record', 'vvvkor\cms\Services\RecordService')
				{!! $record->subSections($table, $rec->id, 'cms::table') !!}
			
				@if (@$subrecords && $subrecords->count()>0)
					<h3>ViewComposer as include</h3>
					@include('cms::table', ['aside'=>1, 'records'=>$subrecords,'columns'=>$subcols])
				@endif
				
				@if (@$subrecords && $subrecords->count()>0)
					<h3>ViewComposer as component</h3>
					@component('cms::table', ['aside'=>1, 'records'=>$subrecords,'columns'=>$subcols, 'table'=>$table])
					@endcomponent
				@endif
			--}}
			@endif
		@endif
	</aside>

</div>
@endsection
