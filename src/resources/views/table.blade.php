@php ($can_switch = ($table=='sections') )
@php ($viewMode = session('view-'.$table.(@$aside ? '-sub' : ''), 'table') )

@if($can_switch)
	<div class="float-md-right">
		@php( $viewModes = ['table'=>'view-table', 'list'=>'view-list'] )
		@foreach($viewModes as $k=>$v)
			<a href="?view={{ $k }}{{ @$aside ? '&sub=1' : ''}}" class="{{ ($k==$viewMode ) ? 'active font-weight-bold' : ''}}">{{ __('cms::list.'.$v) }}</a>
		@endforeach
	</div>
@endif

<h2 class="my-3">
<a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table) }}</a>
</h2>

@php( $tree = ($can_switch && $viewMode=='list') )

@if($tree)
	@if(@$canCreate)
		<div class="my-3">
			<a class="btn btn-success" href="{{ route('admin.'.$table.'.create') }}" title="{{ __('cms::add') }}">
			{{ __('cms::common.add') }}
			</a>
		</div>
	@endcan
	@component('cms::sectree', ['nav'=>$nav, 'root'=>@$root])
	@endcomponent
@else
<div class="table-responsive my-3">
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
		@foreach ($columns as $col)
		<th>{{ $col['l'] }}
		@endforeach
	</thead>

	@foreach ($records as $v)
	@can('view', $v)
    <tr class="{{ $v->e ? '' : 'table-warning' }}">
		<td>
			@can('update', $v)
				<a class="text-primary" href="{{ route('admin.'.$table.'.turn', ['id' => $v->id, 'do' => $v->e ? 'off' : 'on']) }}"
					title="{{ __('cms::db.'.$table.'-e'.($v->e ? '-turn-off' : '-turn-on')) }}">
					{{-- __('cms::db.'.$table.'-e'.($v->e ? '' : '-off')) --}}
					{{ __('cms::db.'.$table.'-e'.($v->e ? '-turn-off' : '-turn-on')) }}</a>
				<a class="text-info" href="{{ route('admin.'.$table.'.edit', ['id' => $v->id]) }}"
					title="{{ __('cms::common.edit') }} {{ $v->name }}">
					{{ __('cms::common.edit') }}</a>
			@endcan
			@can('delete', $v)
				{{-- confirmDelete --}}
				<a class="text-danger" href="{{ route('admin.'.$table.'.show', ['id' => $v->id]) }}" 
					title="{{ __('cms::common.delete') }} {{ $v->name }}">
					{{ __('cms::common.delete') }}</a>
			@endcan
			@if($table=='sections')
				@can('view', $v)
					<a class="text-secondary" href="{{ route('page', ['url'=>$v->url]) }}" title="{{ __('cms::common.view') }}">{{ __('cms::common.view') }}</a>
				@endcan
			@endif
		@foreach ($columns as $k=>$col)
			<td>
			@if($k=='name')
				@can('update', $v)
					<a href="{{ route('admin.'.$table.'.edit', ['id' => $v->id]) }}"><b>{{ $v->$k }}</b></a>
				@else
					{{ $v->$k }}
				@endcan
			@else
				{{ $v->$k }}
			@endif
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