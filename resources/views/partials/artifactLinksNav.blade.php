<li><a href="/artifact-edit/{{ $contentId }}">Build</a></li>
<ul role="menu">
	<li class="vertical-spacer-10"><a href="/artifact-edit/{{$contentId }}">{{ $contentTitle }}</a></li>
	@foreach($sections as $key => $value)
    	<li><a href="/artifact/{{ $contentId }}/{{$value['id'] }}">{{ $value['section_title'] }}</a></li>       
	@endforeach
</ul>


	<li><a href="/artifact-tags/{{ $contentId }}">Tag</a></li>
    <li><a href="/artifact-collaboration/{{ $contentId }}">Collaborate @if($commentsCount > 0)({{ $commentsCount }})@endif</a></li>
    <li><a href="/artifact-notes/{{ $contentId }}">Notes from the field</a></li>