<section>

@if (@$editable)
	<a href="{{ action('\vvvkor\cms\Http\Controllers\SectionController@edit', ['id' => $sec->id]) }}" class="float-md-right" title="{{ __('cms::common.edit').' "'.$sec->name.'"' }}">{{ __('cms::common.edit') }}</a>
@endif

<{{ $current ? 'h1' : 'h2' }}>
	<a href="{{ route('front', ['path'=>$sec->url]) }}">{{ $sec->h1 }}</a>
</{{ $current ? 'h1' : 'h2' }}>

@if($sec->mode && $sec->pub_dt)
	<p><small class="mark-n"><time datetime="{{ $sec->pub_dt }}">{{ $sec->pub_dt }}</time></small></p>
@endif

@component('cms::attach', ['table'=>'sections', 'id'=>$sec->id, 'fnm'=>$sec->fnm])
@endcomponent

{!! $sec->body !!}

</section>