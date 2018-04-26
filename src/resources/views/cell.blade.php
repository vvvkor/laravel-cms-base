@if($column=='name')
	@if($canUpdate)
		<a href="{{ route('admin.'.$table.'.edit', ['id' => $row->id]) }}"><b>{{ $value }}</b></a>
	@else
		{{ $value }}
	@endif
@else
	@if(isset($col['r']))
		@if(is_array($col['r']))
			{{ __('cms::list.'.$table.'-'.$column.'-'.$value) }}
		@else
			<a href="{{ route('admin.'.$col['r'].'.edit', ['id'=>$value]) }}">{{ $value ? cms()->recName($col['r'], $value) : '-' }}</a>
		@endif
	@elseif(@$col['t']=='date')
			{{ date('d.m.Y', strtotime($value)) }}
	@elseif(@$col['t']=='datetime-local')
			{{ date('d.m.Y H:i:s', strtotime($value)) }}
	@elseif(@$col['t']=='textarea')
		{!! cms()->excerpt($value,'...') !!}
	@elseif(@$col['t']=='password')
		@if($value)
			***
		@endif
	@elseif(@$col['t']=='email')
		@if($value)
			<a href="mailto:{{ $value }}">{{ $value }}</a>
		@endif
	@elseif(@$col['t']=='checkbox')
		@if($value)
			{{ __('cms::db.'.$table.'-'.$column) }}
		@else
			{{ __('cms::db.'.$table.'-'.$column.'-off') }}
		@endif
	@else
		{{ $value }}
	@endif
@endif
