@extends('cms::page')

@section('bread','')

@section('main')

<h2 class="my-3">
<a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table.'1') }}</a>
<span class="text-secondary">#{{ $rec->id }}</span>
<a href="{{ route('admin.'.$table.'.edit',$rec->id) }}">{{ $rec->name }}</a>
</h2>


<form method="post" action="{{ route('admin.'.$table.'.destroy', ['id'=>$rec->id]) }}">
	@csrf
	@method('DELETE')
	<button type="submit" class="btn btn-danger">{{ __('cms::common.delete') }} "{{ $rec->$nmf }}"</button>
	<!--a href="{{ route('admin.'.$table.'.destroy', $rec->id) }}" class="btn btn-danger">{{ __('cms::common.delete') }} "{{ $rec->$nmf	 }}"</a-->
	
	<a href="{{ route('admin.'.$table.'.edit', $rec->id) }}" class="btn btn-primary">{{ __('cms::common.edit') }} "{{ $rec->$nmf }}"</a>
	<a href="{{ route('admin.'.$table.'.index') }}" class="btn btn-secondary">{{ __('cms::common.cancel') }}</a>
	@if ($table=='sections')
	<a href="{{ route('page', $rec->url) }}" class="btn btn-link">{{ __('cms::common.view') }}</a>
	@endif
</form>

@endsection