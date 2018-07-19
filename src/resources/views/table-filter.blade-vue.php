@php( $eid = 'el-'.$table.(@$tag ? '-'.$tag : '') )
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

	<div class="form-row my-1" v-for="(filter, index) in filters">
		<div class="col-auto">
			<select name="field[]" class="form-control" v-model="filter[0]">
				<option value="">-</option>
				@foreach ($columns as $k=>$col)
					<option value="{{ $k }}">{{ $col['l'] }}</option>
				@endforeach
			</select>
		</div>
		<template v-if="(!filter[0] || (columns[filter[0]]['t'])!='checkbox')">
			<div class="col-auto">
				<select name="oper[]" class="form-control mr-1" v-model="filter[1]">
					@foreach($operators as $k=>$v)
						<option value="{{ $k }}">{{ $v }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-auto">
				<input type="search" name="filter[]" class="form-control mr-1" v-model="filter[2]">
			</div>
		</template>
		<div v-else class="col-auto form-check form-check-inline">
			@php( $bid = 'box-'.$table.'-'.@$tag )
			<input name="oper[]" type="hidden" value="=">
			<input name="filter[]" type="hidden" v-bind:value="filter[2] ? 1 : ''">
			<input id="{{ $bid }}" type="checkbox" name="filter_box[]" class="form-check-input" value="1" v-model="filter[2]">
			<label class="form-check-label" for="{{ $bid }}">{{ __('cms::common.on') }}</label>
		</div>

			<div v-if="index==filters.length-1" class="col-auto">
				<input type="hidden" name="table" value="{{ $table }}">
				<input type="hidden" name="tag" value="{{ @$tag }}">
				<button type="submit" class="btn btn-primary">{{ __('cms::common.filter') }}</button>
				<button type="submit" class="btn btn-success" v-on:click.prevent="addFilter">{{ __('cms::common.add') }}</button>
				<button type="submit" name="reset" value="1" class="btn btn-light">{{ __('cms::common.reset') }}</button>
			</div>
	</div>
</form>
	
	<example-component></example-component>
	<the-com></the-com>
</div>

<script>
/*
new Vue({
	el: '#{{ 	$eid }}',
	data: {
		columns: {!! json_encode($columns) !!},
		filters: {!! json_encode($filters) !!}
	},
	created: function(){
		this.addFilter();
	},
	methods:{
		addFilter: function(){
			this.filters.push(['','=','']);
		}
	}
});
*/
</script>
