<section>

@can('update', $sec)
	<a href="{{ route('admin.sections.edit', ['id' => $sec->id]) }}" class="float-md-right" title="{{ __('cms::common.edit').' "'.$sec->name.'"' }}">{{ __('cms::common.edit') }}</a>
@endcan

<h2>
	<a href="{{ route('page', ['url'=>$sec->url]) }}">{{ $sec->h1 }}</a>
</h2>

@if($sec->mode && $sec->pub_dt)
	<p><small class="mark-n"><time datetime="{{ $sec->pub_dt }}">{{ $sec->pub_dt }}</time></small></p>
@endif

@component('cms::attach', ['table'=>'sections', 'id'=>$sec->id, 'fnm'=>$sec->fnm])
@endcomponent

{!! cms()->excerpt($sec->body) !!}
<p>
<a href="{{ route('page', ['url'=>$sec->url]) }}">{{ __('cms::common.read-more') }}</a>
</p>

</section>