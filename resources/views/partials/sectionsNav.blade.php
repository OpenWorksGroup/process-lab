<li><a href="/artifact-builder/{{ $templateId }}">{{ $contentTitle }}</a></li>
      <li><a href="/artifact-builder/{{ $templateId }}">Build</a></li>
<ul role="menu">
@foreach($sections as $key => $value)
    <li><a href="/artifact/{{ $contentId }}/{{$value['id'] }}">{{ $value['section_title'] }}</a></li>       
@endforeach
</ul>