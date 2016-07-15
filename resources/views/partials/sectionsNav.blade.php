<li><a href="/artifact-builder/{{ $templateId }}">Build</a></li>
<ul role="menu">
	<li class="vertical-spacer-10"><a href="/artifact-builder/{{ $templateId }}">{{ $contentTitle }}</a></li>
	@foreach($sections as $key => $value)
    	<li><a href="/artifact/{{ $contentId }}/{{$value['id'] }}">{{ $value['section_title'] }}</a></li>       
	@endforeach
</ul>