@php ($cur = $sec)
@php ($bread = [])

@while($cur)
	@php ( array_unshift($bread, $cur) )
	@php ($cur = $cur->parent_id ? (@$nav[$cur->parent_id] ?: cms()->section($cur->parent_id,null,'id')) : null)
@endwhile

@if ((sizeof($bread)>1 || @$table) && (!@$table || ($table=='sections' /*&& $sec->parent_id*/)))
	<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
	@if(@$table)
		<li class="breadcrumb-item"><a href="{{ route('admin.'.$table.'.index') }}">{{ __('cms::db.'.$table) }}</a>
	@endif

	@foreach($bread as $v)
		<li class="breadcrumb-item {{ $loop->last ? '' : 'active' }}">
		@if ($loop->last)
			{{ $v->name }}
		
			{{-- translations --}}
			@if($table && sizeof(config('cms.languages'))>1)
				&nbsp;&mdash;&nbsp;
				
				@php ( $trans = cms()->translations($v->url) )
				@foreach (config('cms.languages') as $code => $label)
					@if(!$loop->first)
						|
					@endif
					@if($v->lang==$code)
						<span class="active font-weight-bold">{{ $code }}</span>
					@elseif(isset($trans[$code]))
						<a href="{{ route('admin.'.$table.'.edit', ['id'=>$trans[$code]['id']]) }}">{{ $code }}</a>
					@else
						<span class="text-secondary">{{ $code }}</span>
					@endif
				@endforeach
				
			@endif

		@else
			@if(@$table)
				<a href="{{ route('admin.'.$table.'.edit', ['id'=>@$v->id]) }}">{{ $v->name }}</a>
			@else
				<a href="{{ route('page', ['url'=>@$v->url]) }}">{{ $v->name }}</a>
			@endif
		@endif
	@endforeach
	</ol>
	</nav>
@endif