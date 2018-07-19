<form class="-form-inline my-2">

<table-filter
	v-bind:initial-filters="{{ json_encode($filters) }}"
	v-bind:columns="{{ json_encode($columns) }}"
	v-bind:operators="{{ json_encode($operators) }}"
	table="{{ @$table }}"
	tag="{{ @$tag }}"
>
</table-filter>

<input type="hidden" name="table" value="{{ @$table }}">
<input type="hidden" name="tag" value="{{ @$tag }}">
<button type="submit" class="btn btn-primary">{{ __('cms::common.filter') }}</button>
<button type="submit" name="reset" value="1" class="btn btn-light">{{ __('cms::common.reset') }}</button>

</form>
