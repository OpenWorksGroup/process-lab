<ul>
	@foreach($fieldsMissing as $field)
		<li><a href="/artifact/{{ $contentId }}/{{ $field['section_id'] }}">
		{{ $field['section_title'] }} - {{ $field['field_title'] }}</a></li>
	@endforeach
</ul>