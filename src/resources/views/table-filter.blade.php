<form class="-form-inline my-2">

<table-filter
	v-bind:initial-filters="{{ json_encode($filters) }}"
	v-bind:columns="{{ json_encode($columns) }}"
	v-bind:operators="{{ json_encode($operators) }}"
	table="{{ @$table }}"
	tag="{{ @$tag }}"
>
</table-filter>

<noscript>
	@php( $eid = 'el-'.$table.(@$tag ? '-'.$tag : '') )
	@php( $filters[] = ['','=',''] )
	@php( $operators = [
		'=' => '=',
		'<>' => '<>',
		'<' => '<',
		'>' => '>',
		'<=' => '<=',
		'>=' => '>=',
		'like' => __('cms::common.like'),
		'not like' => __('cms::common.not-like')
	] )

	@foreach($filters as $filter)
	@if(isset($filter[0]) && isset($filter[1]) /*&& isset($filter[2])*/)
		<div class="form-row my-1">
			<div class="col-auto">
				<select name="field_nojs[]" class="form-control">
					<option value="">-</option>
					<!--option value="any" {{ $filter[0]=='any' ? 'selected' : '' }}>{{ __('cms::common.any') }}</option-->
					@foreach ($columns as $k=>$col)
						<option value="{{ $k }}" {{ $filter[0]==$k ? 'selected' : '' }}>{{ $col['l'] }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-auto">
				<select name="oper_nojs[]" class="form-control mr-1" value="{{ $filter[1] }}">
					@foreach($operators as $k=>$v)
						<option value="{{ $k }}" {{ $filter[1]==$k ? 'selected' : '' }}>{{ $v }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-auto">
				<input type="search" name="filter_nojs[]" class="form-control mr-1" value="{{ $filter[2] }}">
			</div>
		</div>
	@endif
	@endforeach
</noscript>

<input type="hidden" name="table" value="{{ @$table }}">
<input type="hidden" name="tag" value="{{ @$tag }}">
<button type="submit" class="btn btn-primary">{{ __('cms::common.filter') }}</button>
<button type="submit" name="reset" value="1" class="btn btn-light">{{ __('cms::common.reset') }}</button>

</form>
