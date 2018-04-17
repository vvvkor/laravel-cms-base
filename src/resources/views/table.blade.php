<h2 class="my-3">
<a href="{{ action($controller.'@index') }}">{{ __('cms::db.'.$table) }}</a>
</h2>

<div class="table-responsive my-3">
<table class="table -table-striped table-bordered table-hover">
	<thead class="thead-light">
	<tr class="bg">
		<th>
			{{ __('cms::common.tools') }}
			@can('create',$model)
				<a class="text-success" href="{{ action($controller.'@create') }}" title="{{ __('cms::add') }}">
				{{ __('cms::common.add') }}
				</a>
			@endcan
			<!--input type="search" name="_q" size="5"-->
		@foreach ($columns as $k)
		<th>{{ __('cms::db.'.$table.'-'.$k) }}
		@endforeach
	</thead>

	@foreach ($records as $v)
	@can('view', $v)
    <tr>
		<td>
			@can('update', $v)
				<a class="text-info" href="{{ action($controller.'@edit', ['id' => $v->id]) }}"
					title="{{ __('cms::common.edit') }} {{ $v->name }}">
					{{ __('cms::common.edit') }}</a>
			@endcan
			@can('delete', $v)
				{{-- confirmDelete --}}
				<a class="text-danger" href="{{ action($controller.'@'.'show', ['id' => $v->id]) }}" 
					title="{{ __('cms::common.delete') }} {{ $v->name }}">
					{{ __('cms::common.delete') }}</a>
			@endcan
		@foreach ($columns as $k)
		<td>{{ $v->$k }}
		@endforeach
	@else
		<tr><td colspan="{{ 1+sizeof($columns) }}">{{ $v->id }}
	@endcan
	@endforeach
	
</table>
</div>
	
<div class="my-3">
	{{ $records->links() }}
</div>

@if(!@$aside && $table=='sections')
	@component('cms::sectree', ['nav'=>@$nav, 'controller'=>$controller])
	@endcomponent
@endif