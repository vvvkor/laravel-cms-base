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

<div id="{{ $eid }}">
<form class="-form-inline my-2">
@foreach($filters as $filter)
@if(isset($filter[0]) && isset($filter[1]) /*&& isset($filter[2])*/)
	<div class="form-row my-1" xv-for="(filter, index) in filters">
		<div class="col-auto">
			<select name="field[]" class="form-control">
				<option value="">-</option>
				<!--option value="any" {{ $filter[0]=='any' ? 'selected' : '' }}>{{ __('cms::common.any') }}</option-->
				@foreach ($columns as $k=>$col)
					<option value="{{ $k }}" {{ $filter[0]==$k ? 'selected' : '' }}>{{ $col['l'] }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-auto">
			<select name="oper[]" class="form-control mr-1" value="{{ $filter[1] }}">
				@foreach($operators as $k=>$v)
					<option value="{{ $k }}" {{ $filter[1]==$k ? 'selected' : '' }}>{{ $v }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-auto">
			<input type="search" name="filter[]" class="form-control mr-1" value="{{ $filter[2] }}">
		</div>
		
		@if($filter[0])
		<div class="col-auto form-check form-check-inline" x-bind:class="{ 'd-none': (columns[]['t']!='checkbox') }">
			@php( $bid = 'box-'.$table.'-'.@$tag )
			<input id="{{ $bid }}" type="checkbox" name="filter_box[]" class="form-check-input" value="1" {{ $filter[2] ? 'checked' : '' }}>
			<label class="form-check-label" for="{{ $bid }}">{{ __('cms::db.'.$table.'-'.$filter[0]) }}</label>
		</div>
		@endif
		@if($loop->last)
			<div class="col-auto">
				<input type="hidden" name="table" value="{{ $table }}">
				<input type="hidden" name="tag" value="{{ @$tag }}">
				<button type="submit" class="btn btn-primary">{{ __('cms::common.filter') }}</button>
				<button type="submit" name="reset" value="1" class="btn btn-light">{{ __('cms::common.reset') }}</button>
			</div>
		@endif
	</div>
@endif
@endforeach
</form>
</div>

<script>
new Vue({
	el: '#{{ $eid }}',
	data: {
		columns: {!! json_encode($columns) !!},
		filters: {!! json_encode($filters) !!}
	}
});
</script>
