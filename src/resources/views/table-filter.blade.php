<br
	v-bind:filters="{{ json_encode($filters) }}"
	v-bind:columns='{{ json_encode($columns) }}'
>
	
<table-filter
	v-bind:filters="{{ json_encode($filters) }}"
	v-bind:columns='{{ json_encode($columns) }}'
	v-bind:operators='{"=":"=","<>":"<>"}'
	table="{{ @$table }}"
	tag="{{ @$tag }}"
>
</table-filter>