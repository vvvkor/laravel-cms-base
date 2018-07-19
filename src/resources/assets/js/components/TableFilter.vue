<template>

<form class="-form-inline my-2">

	<div class="form-row my-1" v-for="(filter, index) in filters">
		<div class="col-auto">
			<select name="field[]" class="form-control" v-model="filter[0]">
				<option value="">-</option>
				<option v-for="(column, colname) in columns" v-bind:value="colname">{{ column['l'] }}</option>
			</select>
		</div>
		<template v-if="(!filter[0] || (columns[filter[0]]['t'])!='checkbox')">
			<div class="col-auto">
				<select name="oper[]" class="form-control mr-1" v-model="filter[1]">
					<option v-for="(opname, op) in operators" v-bind:value="op">{{ opname }}</option>
				</select>
			</div>
			<div class="col-auto">
				<input type="search" name="filter[]" class="form-control mr-1" v-model="filter[2]">
			</div>
		</template>
		<div v-else class="col-auto form-check form-check-inline">
			<input name="oper[]" type="hidden" value="=">
			<input name="filter[]" type="hidden" v-bind:value="filter[2] ? 1 : ''">
			<input type="checkbox" name="filter_box[]" class="form-check-input" value="1" v-model="filter[2]">
		</div>

			<div v-if="index==filters.length-1" class="col-auto">
				<input type="hidden" name="table" v-model="table">
				<input type="hidden" name="tag" v-model="tag">
				<button type="submit" class="btn btn-primary">Filter</button>
				<button type="submit" class="btn btn-success" v-on:click.prevent="addFilter">Add</button>
				<button type="submit" name="reset" value="1" class="btn btn-light">Reset</button>
			</div>
	</div>
</form>
	
</template>

<script>
    export default {
		props: {
			columns: Object,
			filters: Array,
			operators: Object,
			table: String,
			tag: String
		},
		created: function(){
			this.addFilter();
		},
		methods:{
			addFilter: function(){
				this.filters.push(['','=','']);
			}
		},
        mounted() {
            console.log('Table filter mounted!')
        }
    }
</script>
