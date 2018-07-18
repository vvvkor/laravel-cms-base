@php ($can_switch = ($table=='sections') )
@php ($viewMode = session('view-'.$table.(@$tag ? '-'.$tag : ''), 'table') )

@if($can_switch)
	<div class="float-md-right">
		@php( $viewModes = ['table'=>'view-table', 'list'=>'view-list'] )
		@foreach($viewModes as $k=>$v)
			<a href="?view={{ $k }}{{ @$tag ? '&tag='.$tag : ''}}" class="{{ ($k==$viewMode ) ? 'active font-weight-bold' : ''}}">{{ __('cms::list.'.$v) }}</a>
		@endforeach
	</div>
@endif

<h2 class="my-3">
@if(isset($title))
	{{ $title }}
@else
	<a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table) }}</a>
@endif
</h2>

@php( $tree = ($can_switch && $viewMode=='list') )

@if($tree)
	@if(@$canCreate)
		<div class="my-3">
			<a class="{{ @$aside ? 'text-success' : 'btn btn-success' }}" href="{{ route('admin.'.$table.'.create') }}" title="{{ __('cms::add') }}">
			{{ __('cms::common.add') }}
			</a>
		</div>
	@endcan
	@component('cms::sectree', ['nav'=>@$aside ? $records : cms()->nav(), 'root'=>@$root])
	@endcomponent
@else
<div class="table-responsive my-3">

	@if(!@$aside)
		@include('cms::table-filter')
	@endif

<table class="table table-bordered -table-striped -table-hover">
	<thead class="thead-light">
	<tr class="bg">
		<th>
			{{ __('cms::common.tools') }}
			@if(@$canCreate)
				<a class="text-success" href="{{ route('admin.'.$table.'.create') }}" title="{{ __('cms::add') }}">
				{{ __('cms::common.add') }}
				</a>
			@endcan
			<!--input type="search" name="_q" size="5"-->
		@foreach ($columns as $k=>$col)
		<th><span class="{{ @array_pluck($filters,2,0)[$k] ? 'bg-warning' : '' }}">{{ $col['l'] }}</span>
			@php( $n = array_search($k, array_keys($orders)) )
			@php( $n = ($n===false) ? '' : $n+1 )
			<br>
			<nobr>
				<a href="?order={{ $k }}" class="{{ isset($orders[$k]) && !$orders[$k] ? 'bg-warning' : '' }}">&uarr;</a>
				<a href="?order={{ $k }}&desc=1" class="{{ isset($orders[$k]) && $orders[$k]  ? 'bg-warning' : '' }}">&darr;</a>
				@if($n)
					<span class="text-secondary">{{ $n }}</span>
				@endif
			</nobr>
		@endforeach
	</thead>

	@foreach ($records as $v)
		@php ( $canView = $canUpdate = $canDelete = @$policy ? 0 : 1 )
		@if(@$policy)
			@can('view', $v)
				@php ( $canView = 1 )
			@endcan
			@can('update', $v)
				@php ( $canUpdate = 1 )
			@endcan
			@can('delete', $v)
				@php ( $canDelete = 1 )
			@endcan
		@endif
	
	@if($canView)
    <tr class="{{ (isset($v->enabled) && !$v->enabled) ? 'table-warning' : '' }}">
		<td>
			@if($canUpdate)
				<a class="text-primary" href="{{ route('admin.'.$table.'.edit', ['id' => $v->id]) }}"
					title="{{ __('cms::common.edit') }} {{ $v->name }}">
					{{ __('cms::common.edit') }}</a>
				@if(isset($v->enabled))
					<a class="text-info" href="{{ route('admin.'.$table.'.turn', ['id' => $v->id, 'do' => $v->enabled ? 'off' : 'on']) }}"
						title="{{ __('cms::db.'.$table.'-enabled'.($v->enabled ? '-turn-off' : '-turn-on')) }}">
						{{-- __('cms::db.'.$table.'-enabled'.($v->enabled ? '' : '-off')) --}}
						{{ __('cms::db.'.$table.'-enabled'.($v->enabled ? '-turn-off' : '-turn-on')) }}</a>
				@endif
			@endif
			@if($canDelete)
				{{-- confirmDelete --}}
				<a class="text-danger" href="{{ route('admin.'.$table.'.show', ['id' => $v->id]) }}" 
					title="{{ __('cms::common.delete') }} {{ $v->name }}">
					{{ __('cms::common.delete') }}</a>
			@endif
			@if($table=='sections' && $canView)
					<a class="text-secondary" href="{{ route('page', ['url'=>$v->url]) }}" title="{{ __('cms::common.view') }}">{{ __('cms::common.view') }}</a>
			@endif
		@foreach ($columns as $k=>$col)
			<td>
				@component('cms::cell', [
					'table' => $table,
					'column' => $k,
					'value' => $v->$k,
					'col' => $col,
					'row' => $v,
					'canUpdate' => $canUpdate
					])
				@endcomponent
		@endforeach
	@else
		<tr><td colspan="{{ 1+sizeof($columns) }}">{{ $v->id }}
	@endif
	@endforeach
	
</table>
</div>
	
@if( method_exists($records, 'links') )
	<div class="my-3">
		{{ $records->links() }}
	</div>
@endif
@endif