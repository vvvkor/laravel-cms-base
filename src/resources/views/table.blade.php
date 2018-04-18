@php ($can_switch = (!@$aside && $table=='sections') )
@php ($viewMode = session('view-'.$table, 'table') )

@if($can_switch)
	<div class="float-md-right">
		@php( $viewModes = ['table'=>'view-table', 'list'=>'view-list'] )
		@foreach($viewModes as $k=>$v)
			<a href="?view={{ $k }}" class="{{ ($k==$viewMode ) ? 'active font-weight-bold' : ''}}">{{ __('cms::list.'.$v) }}</a>
		@endforeach
	</div>
@endif

<h2 class="my-3">
<a href="{{ action($controller.'@'.'index') }}">{{ __('cms::db.'.$table) }}</a>
</h2>

@php( $tree = ($can_switch && $viewMode=='list') )

@if($tree)
	@can('create',$model)
		<div class="my-3">
			<a class="btn btn-success" href="{{ action($controller.'@'.'create') }}" title="{{ __('cms::add') }}">
			{{ __('cms::common.add') }}
			</a>
		</div>
	@endcan
	@component('cms::sectree', ['nav'=>$nav, 'controller'=>$controller, 'root'=>@$rec->id])
	@endcomponent
@else
<div class="table-responsive my-3">
<table class="table -table-striped table-bordered table-hover">
	<thead class="thead-light">
	<tr class="bg">
		<th>
			{{ __('cms::common.tools') }}
			@can('create',$model)
				<a class="text-success" href="{{ action($controller.'@'.'create') }}" title="{{ __('cms::add') }}">
				{{ __('cms::common.add') }}
				</a>
			@endcan
			<!--input type="search" name="_q" size="5"-->
		@foreach ($columns as $col)
		<th>{{ $col['l'] }}
		@endforeach
	</thead>

	@foreach ($records as $v)
	@can('view', $v)
    <tr>
		<td>
			@can('update', $v)
				<a class="text-info" href="{{ action($controller.'@'.'edit', ['id' => $v->id]) }}"
					title="{{ __('cms::common.edit') }} {{ $v->name }}">
					{{ __('cms::common.edit') }}</a>
			@endcan
			@can('delete', $v)
				{{-- confirmDelete --}}
				<a class="text-danger" href="{{ action($controller.'@'.'show', ['id' => $v->id]) }}" 
					title="{{ __('cms::common.delete') }} {{ $v->name }}">
					{{ __('cms::common.delete') }}</a>
			@endcan
		@foreach ($columns as $k=>$col)
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
@endif